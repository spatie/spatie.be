# GitHub-advertenties op Laravel Cloud

Uitgerold op 22 oktober 2026 via [PR #504](https://github.com/spatie/spatie.be/pull/504). Productie gebruikt de private EU-bucket `spatie-github-ads`. De vaste README-URL is bijvoorbeeld [https://spatie.be/github-ad-image/laravel-permission.jpg](https://spatie.be/github-ad-image/laravel-permission.jpg).

GitHub Camo haalt de volledige afbeelding op via Cloudflare. Een cachehit bereikt Laravel niet. Bij een cachemiss leest de [controller](../../app/Http/Controllers/GitHubAdImageController.php) het repositorybestand uit de private bucket en streamt de bytes met het echte MIME-type. Een `.jpg`-pad kan dus terecht `image/png` teruggeven. De route geeft geen applicatiesessiecookie uit en geeft voor ontbrekende afbeeldingen een niet-cachebare 404 terug.

```http
Cache-Control: public, max-age=120
Cloudflare-CDN-Cache-Control: public, max-age=86400
Content-Type: image/png
```

Cloudflare verwerkt en verwijdert zijn eigen cacheheader. Browsers en downstreamcaches krijgen twee minuten; alleen Cloudflare krijgt een dag. Cachemisses blijven mogelijk per edge-locatie, na verval, cache-evictie, purges en een applicatiedeploy. Er is dus geen garantie dat Laravel wereldwijd slechts één aanvraag krijgt. [Cloud-caching](https://laravel.com/cloud/docs/network#cache-control), [Cloudflare CDN-Cache-Control](https://developers.cloudflare.com/cache/concepts/cdn-cache-control/).

## Opslag en advertentiewissels

Alle 976 oorspronkelijke S3-objecten zijn gekopieerd, samen 524.678.860 bytes. De overdracht bewaart objectpaden, `Content-Type` en overige metadata. Van ieder object zijn inhoudshashes berekend; de doelbestanden zijn gecontroleerd op checksum, lengte en MIME-type. Een deltacontrole na de productiedeploy vond geen achtergebleven wijzigingen. Alle per-repositorybestanden uit de database waren aanwezig.

Disk `github_ads` is op Cloud gekoppeld aan de private bucket. De bestaande public- en private-disks voor de rest van de website zijn behouden. Een echte private upload via de app en de preview met een tijdelijke signed URL zijn op productie getest: HTTP 200, het juiste MIME-type en `Access-Control-Allow-Origin: https://spatie.be`. Het tijdelijke testobject is daarna verwijderd. Filament kan zo bestaande en nieuwe advertentieafbeeldingen bekijken. Zo'n aflopende URL wordt niet in README's gebruikt. [Cloud Object Storage](https://laravel.com/cloud/docs/resources/object-storage).

De [sync-actie](../../app/Actions/SyncRepositoryAdImageToGitHubAdsDiskAction.php) overschrijft het repositorybestand zonder voorafgaande delete. Ze schrijft ook naar `github_ads_legacy`, de bestaande AWS-bucket `github-ads`. Oude commits, tags, forks en externe kopieën blijven daardoor actuele advertenties krijgen. De AWS-hostnaam kan niet via onze DNS naar Cloud worden omgezet. S3 is daarom bewust behouden; er is geen volledige beëindiging van AWS-opslag of de bijbehorende kosten.

Na een geslaagde wijziging of verwijdering wordt de [purgejob](../../app/Jobs/PurgeGitHubAdImageCacheJob.php) na commit verstuurd. Ze wist alleen `/github-ad-image/{repository}.jpg`, begrenst purges tot 60 per minuut en probeert mislukte requests opnieuw. Gewone wijzigingen aan bijvoorbeeld repository-sterren veroorzaken geen afbeeldingskopie of purge. Een gewijzigde originele advertentie wordt doorgezet naar de gekoppelde repositories. Een verwijderde advertentie wordt losgekoppeld en de afbeeldingen verdwijnen uit beide buckets. [Gerichte Cloud-purge](https://laravel.com/cloud/docs/api/environments/purge-edge-cache).

## README-uitrol

| Controle | Resultaat |
| --- | --- |
| Databasevermeldingen onderzocht | 567 |
| Unieke bereikbare publieke Spatie-repositories | 534 |
| README-bestanden gecontroleerd | 745 |
| Repositories met wijzigingen | 414 |
| Gewijzigde README-bestanden | 429 |
| Repositories zonder betrokken links | 120 |
| Verwijderde Oekraïne-steunbanners | 20 |
| Gewijzigde gearchiveerde repositories | 25, oorspronkelijke archiefstatus hersteld |
| Concrete nieuwe afbeeldings-URL's | 380, allemaal HTTP 200 en inhoudelijk gecontroleerd |

Commits zijn rechtstreeks op de bestaande standaardbranch gemaakt: `main`, `master` of, bij Laravel-Excel, `3.1`. Er zijn geen branches hernoemd. Alleen bestaande S3-afbeeldingslinks zijn vervangen; package-placeholders zoals `:package_name` zijn behouden. De Oekraïne-banners inclusief hun links zijn op verzoek verwijderd. Nested README's, waaronder die in de Mailcoach-monorepo, zijn meegenomen.

De 567 databasevermeldingen bevatten 17 dubbele of hernoemde vermeldingen. Acht repositories waren privé, zeven niet meer bereikbaar en één was overgedragen buiten Spatie. Deze vallen buiten de gewijzigde publieke Spatie-repositories. Er zijn geen private repositorynamen in dit verslag opgenomen.

Iedere commit is met de verwachte oorspronkelijke branch-head gemaakt, zodat gelijktijdig werk niet wordt overschreven. De eindcontrole vergelijkt alle README-blobs en alle archiefstatussen met de bedoelde uitkomst. [Commitoverzicht](2026-10-22-github-ads-readme-commits.csv).

## Verificatie

- Productie-CI: 359 tests geslaagd, 1.092 assertions, 5 bestaande skips. PHPStan en formattering slagen.
- Alle 380 concrete afbeeldingsroutes leverden exact de verwachte bytes, het juiste MIME-type en `Cache-Control: max-age=120, public`, zonder applicatiesessiecookie.
- De productie-sync leverde dezelfde hash in de originele upload, het Cloud-repositorybestand en het legacy-S3-bestand.
- Na de queued sync volgde een cachemiss en vervolgens een hit. Er waren geen mislukte jobs.
- Een werkelijk aangepaste README (`array-to-xml`) leverde via GitHub Camo HTTP 200 en exact dezelfde afbeeldingshash als de gemigreerde bron.
- In de eerdere geïsoleerde proef bleef een edgehit na 151 seconden de oude afbeelding tonen terwijl de app sliep (replica-count 0). Een gerichte purge leverde de nieuwe bytes, daarna opnieuw een hit. GitHub Camo vernieuwde de afbeelding na 129 seconden zonder handmatige purge.
- De tijdelijke proefomgeving, proefdatabase en proefbucket zijn na de productietests verwijderd. De gedeelde databasecluster en productieresources zijn behouden.

De proef bevestigt dat de specifieke Cloudflare-header een langere cacheduur dan 120 seconden oplevert. Een volledige wachttijd van 24 uur is niet getest. GitHub Camo heeft daarnaast zijn eigen cache; een Cloud-purge wist die niet rechtstreeks. [GitHub Camo](https://docs.github.com/en/authentication/keeping-your-account-and-data-secure/about-anonymized-urls).

## Beheer

De productieconfiguratie gebruikt `GITHUB_ADS_LEGACY_DISK=github_ads_legacy`, `CLOUD_CACHE_PURGE_ENVIRONMENT_ID` en `CLOUD_CACHE_PURGE_TOKEN`. De oorspronkelijke `GITHUB_ADS_DISK_*`-credentials blijven voor de legacy-S3-disk beschikbaar. Cloud beheert de credentials voor de aangesloten nieuwe disk. Opslagfouten worden niet stil genegeerd.

De purgecredential staat in 1Password als `spatie.be GitHub ads Cloud edge purge`. Ze heeft alleen `environment.edit` op de productieomgeving van `spatie.be`, de kleinste beschikbare permissie voor deze API. Een productiepurge gaf HTTP 200; een purge op de proefomgeving gaf met dezelfde credential HTTP 403. Het token verloopt op **22 oktober 2027**. Maak vóór die datum een vervanger met dezelfde beperking, werk 1Password en de omgevingsvariabele bij, deploy en controleer een advertentiewissel.

Ook afbeeldingsbytes uit de Cloud-edgecache tellen mee als appbandwidth. Boven de gedeelde organisatiebundel kost dat volgens de geraadpleegde tarieven $0,10/GB. Rechtstreeks bucketverkeer heeft geen egresskosten. Opslag van de huidige bestanden kost bij $0,02/GB ongeveer $0,01 per maand, exclusief operaties en legacy-S3. De daadwerkelijke AWS-kosten en het toekomstige CDN-volume zijn niet vastgesteld. [Cloud-prijzen](https://laravel.com/cloud/docs/pricing#calculating-bandwidth-usage).
