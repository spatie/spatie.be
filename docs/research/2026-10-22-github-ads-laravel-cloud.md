# GitHub-advertenties van S3 naar Laravel Cloud

Onderzocht op 22 oktober 2026. Er is een proefroute gebouwd en een aparte Cloud-testomgeving met eigen database en private bucket ingericht. Productieopslag en bestaande README-links zijn niet gewijzigd.

## Conclusie

Technisch haalbaar. De opslag en Laravel-integratie zijn eenvoudig. De grootste verandering is het vervangen van rechtstreeks ingesloten AWS-URL's in README's. Een volledige migratie zonder blijvende afhankelijkheid van S3 vereist gewijzigde links. Oude commits, tags, forks en externe kopieën blijven de oude URL gebruiken.

De vervolgvraag over Cloud-edgecaching levert een bruikbare extra optie: laat Laravel de volledige afbeelding leveren onder een vaste `.jpg`-URL en cache de response op Cloud's bestaande edge. Alleen cachemisses bereiken de app. Dit vermijdt een extra CDN, maar ook gecachete afbeeldingsbytes tellen mee als appbandwidth. Weeg die kosten af tegen rechtstreeks leveren vanuit een bucket. Een redirect is voor deze aanpak niet nodig.

## Huidige situatie, daadwerkelijk gecontroleerd

- De productieconfiguratie van `spatie.be` gebruikt bucket `github-ads`, regio `eu-central-1`, via de S3-driver. De publieke basis-URL is `https://github-ads.s3.eu-central-1.amazonaws.com`.
- Een volledige anonieme S3-listing telde 976 objecten, samen 524.678.860 bytes (500,37 MiB): 948 jpg, 21 png, 5 jpeg en 2 svg. Dit is de actuele objectinhoud, geen inventaris van eventuele oudere objectversies.
- GitHub code search vond 385 bestanden binnen `org:spatie` met deze hostnaam (`incomplete_results: false`). Dit is geen volledige telling van historische verwijzingen, forks of verwijzingen buiten Spatie.
- De [README van laravel-permission](https://github.com/spatie/laravel-permission/blob/main/README.md) gebruikt rechtstreeks `/laravel-permission.jpg?t=1`. Ook de [lokale README](../../README.md) gebruikt de S3-hostnaam.
- Een HEAD-request naar `laravel-permission.jpg` gaf HTTP 200, `Cache-Control: max-age=120, s-maxage=120`, `Content-Type: image/png` en 813.930 bytes. De extensie geeft dus niet noodzakelijk het echte afbeeldingsformaat aan.
- De productieomgeving heeft al de Cloud-buckets `spatie-be-public` en `spatie-be-private`. Voor de proef was er nog geen afzonderlijke ads-bucket in de aangesloten Cloud-organisatie.

Bronnen: read-only Laravel Cloud API, anonieme AWS S3 API en `gh` op onderzoeksdatum. Er zijn geen credentials opgenomen in dit document.

## Wat de applicatie doet

De [Filament-resource](../../app/Filament/Resources/Content/AdResource.php) uploadt originele advertenties naar disk `github_ads`. De [sync-actie](../../app/Actions/SyncRepositoryAdImageToGitHubAdsDiskAction.php) kopieert een origineel naar een vaste bestandsnaam per repository, zoals `laravel-permission.jpg`. Kopieer daarom bij migratie zowel originele uploads als de afgeleide repositorybestanden, met behoud van objectpaden en metadata.

De [randomisatiejob](../../app/Jobs/RandomizeAdsOnGitHubRepositoriesJob.php) wisselt advertenties via repository-updates. De [scheduler](../../app/Console/Kernel.php) plant deze wekelijks. De [diskconfiguratie](../../config/filesystems.php) zet de cacheduur op 120 seconden. [Bestaande tests](../../tests/Feature/GitHubAds/RepositoryTest.php) controleren het aanmaken en verwijderen van repositoryafbeeldingen, maar gebruiken een fake disk. Ze bewijzen geen echte R2- of GitHub-cachewerking.

## Cloud en kosten

Laravel Cloud biedt publieke, S3-compatibele buckets op Cloudflare R2 met een eigen publieke URL. De benodigde Flysystem S3-package staat al in `composer.json`. Publieke toegang geldt voor de hele bucket; object-ACL's moeten worden vermeden. Een eigen domein rechtstreeks op de bucket is in de geraadpleegde Cloud-documentatie niet beschreven. Behandel dit als onbevestigd. [Laravel Object Storage](https://laravel.com/cloud/docs/resources/object-storage).

| Verbruik | Huidig Cloud-tarief |
| --- | --- |
| Opslag | $0,02 per GB per maand |
| Class A, onder andere schrijven, kopiëren en lijsten | $5 per miljoen operaties |
| Class B, onder andere GET en HEAD | $0,50 per miljoen operaties |
| Dataverkeer rechtstreeks uit de bucket | Gratis |

De huidige bestanden kosten ongeveer $0,01 per maand aan opslag, exclusief operaties. Eén miljoen gefactureerde GET/HEAD-operaties komt daar met $0,50 bij. Dit zijn marginale bucketkosten binnen de bestaande Cloud-organisatie. Een extra CDN heeft eigen kosten. [Cloud-prijzen](https://laravel.com/cloud/docs/pricing#laravel-object-storage).

De huidige AWS-factuur en aantallen requests zijn niet onderzocht. Een concrete maandelijkse besparing is daardoor nog niet vastgesteld. GitHub-paginaweergaven zijn ook geen betrouwbare maat voor bucketrequests door tussenliggende caches.

## Migratievoorstel

1. Maak na besluit tot uitvoering een publieke EU-bucket, bijvoorbeeld `spatie-github-ads`, en koppel deze aan productie als `github_ads`. Behoud de andere aangesloten disks. Alternatief: een afgeschermde prefix binnen de bestaande publieke bucket, als een extra bucket ongewenst is.
2. Kopieer alle objecten, zonder de bron te verwijderen. Bewaar `Content-Type` en `Cache-Control`; leid het type niet af uit `.jpg`. Een S3-naar-R2-overdracht gebruikt beide endpoints, bijvoorbeeld via rclone of een download/upload-stap. Een gewone server-side S3-copy tussen providers volstaat niet.
3. Controleer aantallen, bytes en inhoud, en test publieke GET/HEAD. Test daarnaast een upload in Filament, het kopiëren naar een repositorypad, het verwijderen en een advertentiewissel. Behoud korte cacheheaders; controleer dat Cloud de diskopties bij het koppelen niet overschrijft.
4. Probeer één README met de nieuwe publieke bucket- of CDN-URL. Controleer de afbeelding en advertentiewissel via GitHub en het cachegedrag. Een constante queryparameter zoals `?t=1` verandert niet bij een advertentiewissel.
5. Werk na een geslaagde proef de overige actuele README's bij. Houd S3 tijdens de overgang beschikbaar en werk legacy-afbeeldingen mee bij, anders blijven oude links oude advertenties tonen.
6. Beslis afzonderlijk of S3 ooit weg mag. Oude versies en forks blijven ervan afhankelijk. Het verwijderen van S3 breekt hun afbeeldingen, ook wanneer alle actuele Spatie-README's zijn aangepast.

De bestaande AWS-hostnaam is niet via onze DNS om te wijzen naar Cloud. Alleen de writer-disk veranderen laat bestaande README's nog steeds van S3 lezen. Ook S3-website-redirects helpen hier niet: de gebruikte REST-endpoints passen die redirects niet toe. [AWS redirectgedrag](https://docs.aws.amazon.com/AmazonS3/latest/userguide/how-to-page-redirect.html).

## Nog te verifiëren voor uitvoering

GitHub gebruikt Camo voor externe afbeeldingen. Correcte MIME-headers en het werkelijke cachegedrag moeten daarom onderdeel van de proef zijn. Een directe bucketrequest bewijst nog niet dat een README de nieuwe advertentie toont. [GitHub over geanonimiseerde afbeeldings-URL's](https://docs.github.com/en/authentication/keeping-your-account-and-data-secure/about-anonymized-urls).

De specifieke Cloud-documentatie bevestigt geen cache-TTL, purge-mogelijkheid of publieke throughputgarantie voor de uitgegeven bucket-URL. Controleer dit met een proef en eventueel Laravel support. Ga niet uit van de beperkingen of mogelijkheden van gewone `r2.dev`-URL's. [R2 public buckets](https://developers.cloudflare.com/r2/buckets/public-buckets/).

Voor de latere kopie is rclone een concrete optie: eerst `copy --metadata --dry-run`, daarna `copy --metadata` en `check`, met twee vooraf geconfigureerde remotes. Gebruik geen delete/sync op de bron en geen `public-read`-ACL. Controleer de headers daarna via HTTP. [Rclone met R2](https://developers.cloudflare.com/r2/examples/rclone/), [S3-metadata in rclone](https://rclone.org/s3/#metadata).

## Stabiele hostname zonder Laravel-verkeer

Een publieke URL, een eigen hostname en een signed URL zijn verschillende dingen. Cloud levert publieke buckets onder een `fls-….laravel.cloud`-hostname. Private buckets hebben geen permanente publieke URL, maar ondersteunen tijdelijke signed URL's. Die verlopen en zijn daarom ongeschikt als vaste README-link. De publieke bucketdocumentatie beschrijft geen eigen bucket-hostname, en de bucket-update-API en CLI bieden daarvoor geen instelling. Native ondersteuning is daarmee niet bevestigd. [Cloud-buckets](https://laravel.com/cloud/docs/resources/object-storage), [bucket-update-API](https://laravel.com/cloud/docs/api/object-storage-buckets/update-object-storage-bucket).

De DNS van `spatie.be` staat momenteel bij DigitalOcean: `ns1.digitalocean.com`, `ns2.digitalocean.com` en `ns3.digitalocean.com`. `ads.spatie.be` gaf bij de controle geen adres terug. Bron: publieke DNS-query's op onderzoeksdatum.

| Oplossing | Laravel-app geraakt? | Eigen hostname | Voorwaarde |
| --- | --- | --- | --- |
| Publieke Cloud-bucket-URL | Nee | Nee | Nieuwe bucket-URL opnemen in README's |
| Laravel levert de afbeelding met Cloud-edgecaching | Alleen bij cachemiss | Ja, bijvoorbeeld een pad op `spatie.be` | Cookievrije response, cacheheaders en appbandwidth controleren |
| Cloud-bucket met aparte CDN | Nee | Ja | CDN instellen en CNAME toevoegen bij huidige DNS-provider |
| Cloud-bucket met Cloudflare Worker | Nee | Ja | Actieve Cloudflare-zone en Worker-configuratie |
| Eigen R2-bucket met custom domain | Nee | Ja | Zone en bucket in hetzelfde Cloudflare-account |

### Cloud-bucket met Bunny CDN

Een concrete architectuur die met de huidige DNS-provider kan werken:

```text
GitHub / Camo
  -> https://ads.spatie.be/laravel-permission.jpg
  -> Bunny CDN
  -> publieke Laravel Cloud-bucket
```

Maak een Pull Zone met de publieke Cloud-basis-URL als HTTPS-origin, voeg `ads.spatie.be` als hostname toe en maak bij DigitalOcean de opgegeven CNAME. Bunny regelt het certificaat. Laat de origin Host-header op de bucket-hostnaam staan, niet op `ads.spatie.be`. De providerdocumentatie bevestigt deze bouwstenen; de combinatie met een echte Cloud-bucket moet nog in een proef worden gecontroleerd. [Pull Zone en origin](https://bunny.net/docs/cdn/quickstart), [eigen hostname](https://bunny.net/docs/cdn/custom-hostname), [TLS](https://bunny.net/docs/cdn/ssl-setup).

Bij een cachemiss haalt de CDN de afbeelding uit de bucket. Daarbij zijn PHP, de database en de webcontainer van `spatie.be` niet betrokken. De bestaande wekelijkse job kan gewoon de objecten per repository blijven overschrijven. Houd korte cachetijden aan en test een echte wissel. Bunny ziet wijzigingen niet automatisch; een object blijft gecachet tot de ingestelde cacheduur verstrijkt of een purge plaatsvindt. Een purge per URL is beschikbaar via de API. Een Bunny-purge wist de afzonderlijke GitHub Camo-cache niet. [Caching en purge](https://bunny.net/docs/cdn/purge-cache).

Bunny rekent minimaal $1 per maand op accountniveau. De Standard-CDN kost $0,01/GB voor Europa en Noord-Amerika; andere regio's hebben hogere tarieven. Dit komt bovenop Cloud-bucketkosten. Het echte volume bij de CDN, na GitHub-caching, bepaalt de rekening. [Bunny-prijzen](https://bunny.net/pricing/).

De eigen hostname kan eventueel eerst naar S3 via de CDN wijzen. Werk dan de actuele README's bij en wissel pas daarna de CDN-origin naar Cloud. Zo zijn voor die tweede stap geen nieuwe README-wijzigingen nodig. Oude S3-links in historie en forks blijven afzonderlijk bestaan.

### Cloudflare-alternatieven

Een Worker kan met een eigen domein rechtstreeks de publieke Cloud-bucket ophalen. Dit gebruikt Worker-uitvoering in plaats van Laravel-uitvoering. Een Worker Custom Domain vereist echter een actieve Cloudflare-zone. De gewone partial/CNAME-setup om DigitalOcean als authoritative DNS-provider te behouden, vereist Business of Enterprise. Een gewone gratis CNAME naar een `workers.dev`-adres is geen vervanging voor deze configuratie. [Worker Custom Domains](https://developers.cloudflare.com/workers/configuration/routing/custom-domains/), [partial setup](https://developers.cloudflare.com/dns/zone-setups/partial-setup/).

Een eigen R2-bucket kan rechtstreeks aan een eigen domein worden gekoppeld, zonder Worker. Cloudflare vereist daarbij een zone in hetzelfde account als de bucket. Neem daarom niet aan dat we deze functie zelf kunnen gebruiken op een door Laravel beheerde bucket. Voor een eigen R2-bucket in ons account is het een alternatief, met dezelfde DNS-zonevoorwaarde. [R2 custom domains](https://developers.cloudflare.com/r2/buckets/public-buckets/).

Voor alleen deze advertenties is een DNS-verhuizing geen noodzakelijke stap: de publieke Cloud-URL is de eenvoudigste optie, en zowel Cloud-edgecaching als een aparte CDN biedt een eigen URL met behoud van de huidige DNS-provider.

## Volledige afbeelding via Laravel met Cloud-edgecaching

Cloud's edge kan de volledige afbeeldingsresponse van Laravel cachen. Bij een hit levert de edge de bytes zonder de webcontainer te bereiken. Cloud cachet standaard onder andere `.jpg` en `.png`, respecteert expliciete `Cache-Control`-headers en cachet geen responses met `Set-Cookie`. Gebruik daarom bijvoorbeeld `https://spatie.be/github-ad-image/laravel-permission.jpg` met een openbare route zonder sessie- of cookie-uitgifte. De response moet het echte MIME-type van de bronafbeelding behouden. [Cloud-netwerk en caching](https://laravel.com/cloud/docs/network#cache-control).

De proefroute gebruikt deze headers, gecontroleerd op Cloud:

```http
Cache-Control: public, max-age=120
Cloudflare-CDN-Cache-Control: public, max-age=86400
Content-Type: image/png
```

Hiermee krijgen downstreamclients een cacheduur van twee minuten en krijgt alleen Cloudflare een dagcache. Cloudflare verwijdert zijn eigen cacheheader uit de response naar de client. Een algemene `s-maxage=86400` zou ook downstream shared caches een dagcache toestaan. [Cloudflare CDN-Cache-Control](https://developers.cloudflare.com/cache/concepts/cdn-cache-control/).

De lange edge-TTL werkt samen met expliciete invalidatie bij een advertentiewissel. Het is geen garantie dat een afbeelding wereldwijd slechts eenmaal Laravel bereikt: verschillende edge-locaties, verval, cache-evictie, purges en de standaard deploy-purge veroorzaken nieuwe misses. GitHub Camo houdt daarnaast zijn eigen cache bij.

Cloud heeft inmiddels een gedocumenteerde gerichte purge: stuur na een geslaagde afbeeldingsupdate één `path` of `prefix` naar de environment-purge-API. Bijvoorbeeld `{"path":"/github-ad-image/laravel-permission.jpg"}` voor één advertentie of `{"prefix":"/github-ad-image/"}` na de wekelijkse batch. Er mag slechts één selector per request worden gebruikt. Dit kan dus zonder de volledige websitecache te wissen. [Cloud purge-API](https://laravel.com/cloud/docs/api/environments/purge-edge-cache).

Omdat Laravel de bytes leest en zelf terugstuurt, kan de achterliggende bucket ook private zijn. Er is dan geen aflopende signed URL in de README nodig. De afbeeldingroute zelf is publiek; de controller selecteert uitsluitend de advertentie van de gevraagde repository. Controleer bij een private bucket wel de Filament-upload en preview, die nu dezelfde disk gebruiken.

Het belangrijkste financiële verschil: ook data uit Cloud's edgecache telt mee voor appbandwidth. Boven de gedeelde organisatiebundel kost dit $0,10/GB. Rechtstreeks bucketverkeer is gratis qua egress. De cache verlaagt dus computegebruik, maar maakt het verkeer niet automatisch gratis. [Bandwidthberekening](https://laravel.com/cloud/docs/pricing#calculating-bandwidth-usage), [bandwidthtarief](https://laravel.com/cloud/docs/pricing#bandwidth).

### Resultaat van de liveproef

De [draft-PR](https://github.com/spatie/spatie.be/pull/504) bevat de route en regressietests. De proef draait in omgeving `ads-cache-probe`, met een eigen database op de bestaande interne cluster en een aparte private EU-bucket `github-ads-cache-probe`. De scheduler en push-to-deploy staan voor deze omgeving uit. De App-instance gebruikt `flex-512mb` met een idle timeout van één minuut.

De proefafbeelding staat op [de test-URL](https://spatiebe-ads-cache-probe-nrfxtk.laravel.cloud/github-ad-image/laravel-permission.jpg). Er is geen publieke bucket-URL nodig. De proef wisselde uitsluitend het object in de testbucket. De bestaande S3-advertentie is niet gewijzigd.

| Controle | Waargenomen resultaat |
| --- | --- |
| Eerste aanvraag | HTTP 200, `CF-Cache-Status: MISS`, 813.930 bytes |
| Tweede aanvraag | `HIT`, `Age: 2`, dezelfde afbeeldingshash |
| Clientheaders | `Cache-Control: max-age=120, public`, correct `image/png` ondanks `.jpg` |
| Cloudflare-specifieke header | Wordt door de edge verwerkt en niet naar de client doorgestuurd |
| Na wijziging in de testbucket en 151 seconden cacheleeftijd | Nog steeds `HIT` met de oude afbeelding; edgecache leeft langer dan de client-TTL van 120 seconden |
| Cachehit terwijl de app sliep | Replica-count was 0 vanaf 14:02:11 UTC; de `HIT` om 14:02:43 UTC maakte de app niet wakker |
| Gerichte purge met `path` | API HTTP 200 |
| Eerstvolgende aanvraag na purge | `MISS`, nieuwe afbeelding van 923.608 bytes, andere hash |
| Daarna | Opnieuw `HIT` met de nieuwe afbeelding |
| GitHub Camo | Correcte weergave in de draft-PR; 129 seconden na de eerste Camo-fetch kwam de gewijzigde afbeelding door, zonder handmatige Camo-purge |

Alleen de appresponse is cookie-vrij. Cloudflare voegt op de `laravel.cloud`-hostname wel een `__cf_bm`-botcookie toe. De waargenomen `HIT` bevestigt dat deze edgecookie het cachen van deze response niet verhindert. Er is geen applicatiesessiecookie gevonden.

De 151-secondenproef toont aan dat Cloud de specifieke edgeheader respecteert; een volledige wachttijd van 24 uur is niet getest. De later bijgewerkte Cloud-metrics bevestigen dat de app tijdens de cachehit sliep: replica-count 0 vanaf 14:02:11 UTC, de `HIT` om 14:02:43 UTC, en pas weer replica-count 1 om 14:02:47 UTC bij het ophalen na de purge. De cachehit bereikte de webcontainer dus niet.

De lokale controller- en advertentietests slagen. GitHub CI voor de code slaagt ook, inclusief de volledige testsuite (354 geslaagd, 5 overgeslagen), PHPStan en formattering.

Voor een productie-uitrol ontbreken nog de automatische purge na een geslaagde advertentiewissel, de definitieve bucketmigratie en het aanpassen van de README-links. De PR is een proef en is niet gemerged. De bestaande productieomgeving gebruikt nog steeds S3 voor `github_ads`.
