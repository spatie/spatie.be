@extends('layout.default', [
    'background' => '/backgrounds/legal.jpg',
    'title' => 'Disclaimer',
    'description' => 'Our disclaimer. Yes, we have one too.',
])

@section('content')

    <section id="banner" class="banner" role="banner">
        <div class="wrap">
            <h1 class="banner-slogan">
                Disclaimer
            </h1>
            <p class="mt-4">
                <span class="icon mr-2 opacity-50 fill-blue">{{ svg('icons/far-angle-left') }}</span> <a href="{{ route('legal.index')}}" class="link-underline link-blue">Legal overview</a>
            </p>
        </div>
    </section>
    <div class="section-group pt-0">
        <section id="jobs">
            <div class="wrap">
                <div class="markup markup-titles links-underline links-blue bullets bullets-green">
                    <p><em>Dutch version — translation in progress</em></p>

                    <p>Het gebruik van onze website moet steeds gebeuren conform de rechten en plichten die duidelijk op de website vermeld staan en de rechten en plichten die bepaald zijn in de Disclaimer, de Verkoopsvoorwaarden en de Privacy Verklaring. Het geheel van deze teksten zijn onze Algemene Voorwaarden.
                    </p>
                    <p>Deze Algemene Voorwaarden gelden zowel voor ons, SPATIE BVBA, als voor jou, de Gebruiker. Zodra je gebruik maakt van onze website erken en aanvaard je uitdrukkelijk dat onze Algemene Voorwaarden van toepassing zijn en dat volledig verzaakt wordt aan de toepassing van eigen Algemene Voorwaarden.
                    </p>
                    <p>Wij kunnen in uitzonderlijke gevallen afwijken van de Algemene Voorwaarden, voor zover deze afwijkingen schriftelijk worden vastgelegd en aanvaard worden door alle partijen. Deze afwijkingen gelden slechts ter vervanging of aanvulling van de clausules waar ze betrekking op hebben en hebben geen effect op de toepassing van overige bepalingen uit de Algemene Voorwaarden.
                    </p>

                    <h2>1. Wie zijn wij?</h2>

                    <p>De website spatie.be is een initiatief van: </p>
                    <address>
                        SPATIE BVBA<br>
                        Samberstraat 69D<br>
                        2060 Antwerpen<br>
                        E-mail: <a href="mailto:info@spatie.be">info@spatie.be</a><br>
                        Telefoon: +32 3 292 56 79 <br>
                    </address>
                    <p>
                        Contacteer ons gerust indien u verdere vragen of opmerkingen heeft.
                    </p>

                    <h2>2. Onze website</h2>
                    <h3>2.1 Goede werking, veiligheid en toegankelijkheid</h3>
                    <p>
                        Je kan ervan op aan, wij bieden een gebruiksvriendelijke website aan die veilig is voor iedere Gebruiker. We nemen dan ook alle redelijke maatregelen die nodig zijn om de goede werking, veiligheid en toegankelijkheid van onze website te garanderen. Toch kunnen we jou geen absolute garanties geven en moet men onze maatregelen beschouwen als een middelenverbintenis.
                    </p>
                    <p>
                        Ieder gebruik van de website gebeurt steeds op eigen risico. Dit betekent dat wij geen aansprakelijkheid dragen voor schade die voortvloeit uit storingen, onderbrekingen, schadelijke elementen of defecten aan de website, ongeacht het bestaan van een vreemde oorzaak of overmacht.
                    </p>
                    <p>
                        We hebben het recht om de toegang tot onze website te allen tijde te beperken en/of geheel of gedeeltelijk te onderbreken, zonder voorafgaande waarschuwing. We doen dit in principe uitsluitend indien de omstandigheden dit verantwoorden, maar dit is geen absolute voorwaarde.
                    </p>
                    <h3>2.2 Inhoud op onze website</h3>
                    <p>
                        De inhoud van de website wordt grotendeels door ons bepaald en wij besteden de grootste zorg aan deze inhoud. Dit wil zeggen dat we de nodige maatregelen nemen om onze website zo volledig, nauwkeurig en actueel mogelijk te houden, ook wanneer content wordt aangeleverd door derde partijen. De inhoud op onze website kan steeds gewijzigd, aangevuld of verwijderd worden.
                    </p>
                    <p>
                        Toch kunnen we geen garanties geven omtrent de kwaliteit van de informatie op onze website. Het is mogelijk dat informatie niet volledig, voldoende accuraat en/of nuttig is. We zijn bijgevolg niet aansprakelijk voor (directe en indirecte) schade die de Gebruiker lijdt ten gevolge van de informatie op onze website.
                    </p>
                    <p>
                        In het geval bepaalde inhoud op onze website een schending van de geldende wetgeving en/of een schending van de rechten van derde partijen betekent en/of eenvoudigweg niet door de beugel kan, vragen wij aan jou om ons dit zo spoedig mogelijk te melden zodat we de gepaste maatregelen kunnen nemen. Zo kunnen we overgaan tot een gedeeltelijke of gehele verwijdering en/of aanpassing van de inhoud.
                    </p>
                    <p>
                        Onze website bevat inhoud die gedownload kan worden. Iedere download van onze website gebeurt steeds op eigen risico. Hiervoor zijn wij niet aansprakelijk en schade ten gevolge van een verlies van data of schade aan het computersysteem valt volledig en uitsluitend onder de verantwoordelijkheid van Gebruiker.
                    </p>
                    <p>
                        Specifiek voor prijzen en andere informatie over producten op de website geldt een voorbehoud van kennelijke programmeer- en typefouten. De Gebruiker kan op basis van dergelijke fouten geen overeenkomst claimen met SPATIE.
                    </p>

                    <h3>2.3 Wat wij van jou als Gebruiker verwachten</h3>
                    <p>
                        Ook de Gebruiker draagt een zekere verantwoordelijkheid bij het gebruiken van onze website. De Gebruiker moet zich steeds onthouden van handelingen die een schadelijke impact kunnen hebben op de goede werking en veiligheid van de website. Zo mag de website niet gebruikt worden om ons business model te omzeilen en/of om informatie van andere Gebruikers op grote schaal te verzamelen.
                    </p>
                    <p>
                        Het is bijgevolg niet toegelaten om onze website te gebruiken voor de verspreiding van inhoud die schade aan andere Gebruikers van de website kan toebrengen, zoals de verspreiding van schadelijke programmatuur zoals computervirussen, malware, worms, trojans en cancelbots. De verspreiding van ongevraagde en/of commerciële berichten via de website, zoals junk mail, spamming en kettingbrieven, valt hier ook onder.
                    </p>
                    <p>
                        Wij behouden ons het recht voor om alle noodzakelijke handelingen te treffen die herstel kunnen opleveren voor ons en voor onze Gebruikers, zowel op gerechtelijk als buitengerechtelijk vlak. De Gebruiker is als enige persoonlijk en integraal verantwoordelijk indien zijn handelingen en gedragingen effectief schade veroorzaken aan de website en de andere Gebruikers. In dat geval moet hij SPATIE vrijwaren van iedere schadeclaim die volgt.
                    </p>

                    <h2>3. Links naar andere websites</h2>
                    <p>
                        De inhoud van onze website kan een link, hyperlink of framed link naar vreemde websites of andere vormen van elektronische portalen bevatten. Een link betekent niet automatisch dat er een band tussen ons en de vreemde website bestaat, noch dat wij (impliciet) akkoord gaan met de inhoud van deze websites.
                    </p>
                    <p>
                        Wij houden geen controle op deze vreemde websites en zijn niet verantwoordelijk voor de veilige en correcte werking van de link en de uiteindelijke bestemming. Zodra men op de link klikt verlaat men onze website en kan men ons niet meer aansprakelijk stellen voor enige schade.
                    </p>
                    <p>
                        Het is mogelijk dat vreemde websites niet dezelfde garanties bieden als wij. Daarom raden wij aan om aandachtig de Algemene Voorwaarden en de Privacy Statement van deze websites door te nemen.
                    </p>

                    <h2>4. Intellectuele eigendom</h2>
                    <p>
                        Creativiteit verdient bescherming, zo ook onze website en haar inhoud. De bescherming wordt voorzien door intellectuele eigendomsrechten en komt toe aan alle rechthebbende partijen, zijnde SPATIE en derde partijen. Onder inhoud verstaat men de heel ruime categorie van foto’s, video, audio, tekst, ideeën, notities, tekeningen, artikels, et cetera. Al deze inhoud wordt beschermd door het auteursrecht, softwarerecht, databankrecht, tekeningen- en modellenrecht en andere toepasselijke (intellectuele) eigendomsrechten. Het technische karakter van onze website zelf is beschermd door het auteursrecht, het softwarerecht en databankenrecht.  Iedere handelsnaam die wij gebruiken op onze websites wordt eveneens beschermd door het toepasselijke handelsnamenrecht of merkenrecht.
                    </p>
                    <p>
                        Iedere Gebruiker krijgt een beperkt recht van toegang, gebruik en weergave van onze websites en haar inhoud. Dit toegekende recht is niet-exclusief, niet-overdraagbaar en kan enkel binnen een persoonlijk, niet-commercieel kader worden gebruikt. Wij vragen onze Gebruikers dan ook om geen gebruik te maken van en/of wijzigingen aan te brengen in de door deze rechten beschermde zaken, zonder de toestemming van de rechthebbende. SPATIE hecht veel belang aan haar intellectuele eigendomsrechten en heeft hiervoor alle mogelijke maatregelen getroffen om de bescherming te garanderen. Iedere inbreuk op de bestaande intellectuele eigendomsrechten wordt vervolgd.
                    </p>


                    <h2>5. Algemene bepalingen omtrent de Algemene Voorwaarden</h2>
                    <p>
                        Wij behouden de vrijheid om onze website en de daarbij horende diensten te allen tijde te wijzigen, uit te breiden, te beperken of stop te zetten. Dit kan zonder voorafgaande kennisgeving van de Gebruiker en geeft evenmin aanleiding tot enige vorm van schadevergoeding.
                    </p>
                    <p>
                        Deze Algemene Voorwaarden (inclusief de Verkoopsvoorwaarden) worden exclusief beheerst en geïnterpreteerd in overeenstemming met de Belgische Wetgeving. Alle geschillen die verband houden met of voortvloeien uit aanbiedingen van SPATIE, of overeenkomsten die met haar gesloten zijn, worden voorgelegd aan de bevoegde rechtbank uit het gerechtelijk arrondissement Antwerpen.
                    </p>
                    <p>
                        Indien de werking of geldigheid van één of meerdere van bovenstaande bepalingen van deze Algemene Voorwaarden in het gedrang komen, zal dit geen gevolg hebben op de geldigheid van de overige bepalingen van deze overeenkomst. In dergelijk geval hebben wij het recht om de betrokken bepaling te wijzigen in een geldige bepaling van gelijkaardige strekking.
                    </p>

                </div>
            </div>
        </section>
    </div>

@endsection
