@extends('layout.default', [
    'background' => '/backgrounds/legal.jpg',
    'title' => 'Privacy',
    'description' => 'Our privacy policy. Because we respect you.',
])

@section('content')

    <section id="banner" class="banner" role="banner">
        <div class="wrap">
            <h1 class="banner-slogan">
                Privacy policy
            </h1>
            <p class="mt-4 | print:hidden">
                <span class="icon mr-2 opacity-50 fill-blue">{{ svg('icons/far-angle-left') }}</span> <a href="{{ route('legal.index')}}" class="link-underline link-blue">Legal overview</a>
            </p>
        </div>
    </section>
    <div class="section-group pt-0">
        <section>
            <div class="wrap">
                <div class="markup markup-titles markup-lists counters links-underline links-blue">
                    <h2>Why this Privacy Statement</h2>

                    <p>
                        SPATIE attaches great importance to the protection of your privacy and personal data. We use your personal data solely in accordance with the Privacy Law and other relevant legislation in force. Any reference in this Privacy Statement to the Privacy Law means a reference to the law of 8 December 1992 on privacy protection in relation to the processing of personal data. Any reference to the Regulation is a reference to the Regulation of 27 April 2016 on the protection of individuals with regard to the processing of personal data and on the free movement of such data.
                    </p>
                    <p>
                        With this Privacy Statement, SPATIE want to point out to you any processing operations on this data and on your rights. By using our platform/our website/our application you grant your explicit consent for possible processing operations by SPATIE.
                    </p>
                    <p>
                        It is possible that this Privacy Statement is subject to adjustments and changes in the future. It is up to you to consult this document on a regular basis. Any substantial change will always be clearly communicated on the platform of SPATIE.
                    </p>

                    <h2>Who processes your personal data?</h2>

                    <p>The website spatie.be is an initiative of: </p>
                    <address>
                        SPATIE BVBA<br>
                        Kruikstraat 22, Box 12<br>
                        2018 Antwerp<br>
                        Belgium<br>
                        VAT: BE0809.387.596<br>
                        Email: <a href="mailto:info@spatie.be">info@spatie.be</a><br>
                        Telephone: +32 3 292 56 79 <br>
                    </address>


                    <h2>Which personal data are processed?</h2>

                    <p>
                        SPATIE commits to only process data that are relevant and necessary for the purposes for which they were collected. Following categories of personal information may be processed by SPATIE:
                    </p>

                    <ul>
                        <li>Identification details</li>
                    </ul>

                    <h2>For what purposes are my personal data used?</h2>

                    <p>
                        SPATIE collects personal data to give you a safe, optimal and personalised user experience. The collection of personal data is more comprehensive to the extent that you make more intensive use of the platform/the website/application and our online services.
                    </p>
                    <p>
                        Data processing is crucial to the operation of the platform/the website/application and the associated services. The processing is done exclusively for these specific purposes:
                    </p>
                    <ul>
                        <li>
                            Giving you access to your user profile.
                        </li>
                        <li>
                            Offering and improve general and personalised services; including billing purposes, provision of information, newsletters and offers that may be useful or necessary for you, the obtaining and processing of User’s assessments and the providing of support.
                        </li>
                        <li>
                            Offering and improving the supplied products; personal and specific products on the basis of supplied information and data.
                        </li>
                        <li>
                            The detection of and the protection against fraud, errors and/or criminal behaviour.
                        </li>
                        <li>
                            Marketing purposes
                        </li>
                    </ul>
                    <p>
                        When visiting the platform/the website/the application of SPATIE some data are collected for statistical purposes. Such data are necessary to optimise the use of our platform/our website/our application. These data are: IP address, probable place of consultation, hour and day of consultation, which pages were visited. When you visit the platform/the website/ the application of SPATIE you agree to this data collection for statistical purposes as described above.
                    </p>
                    <p>
                        The User always provides personal data to SPATIE and can in this way exercise a certain control. If certain data are incomplete or apparently incorrect, SPATIE retains the right to postpone certain expected actions temporarily or permanently.
                    </p>
                    <p>
                        The personal data will only be processed for internal use within SPATIE.
                        <br>
                        We can reassure you that personal data will not be sold, transmitted or be communicated to third parties who are associated with us. SPATIE has taken all possible legal and technical precautions to prevent unauthorised access and use.
                    </p>

                    <h2>We do not use Cookies</h2>

                    <p>
                        During a visit to our website, no "cookies" are placed on your hard drive.
                    </p>

                    <h2>What are my rights?</h2>
                    <h3>Guarantee of a legitimate and safe processing of the personal data</h3>
                    <p>
                        SPATIE processes your personal data always fairly and lawfully. This includes the following guarantees:
                    </p>
                    <ul>
                        <li>
                            Personal data will only be processed in accordance with specified and legitimate purposes of this Privacy Statement.
                        </li>
                        <li>
                            Personal data are only processed to the extent that this is adequate, relevant and not excessive.
                        </li>
                        <li>
                            Personal data are kept only as long as this is necessary to achieve the specified and legitimate purposes in the Privacy Statement.
                        </li>
                    </ul>
                    <p>
                        The necessary technical and security measures were taken to reduce the risks of illegal access to or processing of the personal data to a minimum. With intrusion into its computer systems, SPATIE will immediately take all possible measures to limit the damage to a minimum.
                    </p>

                    <h3>The right to access/rectification/erasure of your personal data</h3>
                    <p>
                        With proof of your identity as a User, you have the right to receive from SPATIE an answer on whether or not to process your personal data. When SPATIE processes your data, you furthermore have the right to inspect the personal data collected. If you wish to use your right of access, SPATIE will pursue the matter within one (1) month after receiving the request. The application is done via registered mail or by sending an email to  <a href="mailto:info@spatie.be">info@spatie.be</a>
                    </p>
                    <p>
                        Inaccurate or incomplete personal data can always be corrected. It is up to the User in the first place to correct inaccuracies and incomplete information himself. You can exercise your right to make corrections by providing an additional statement to SPATIE. SPATIE will pursue the matter within one (1) month after receiving the additional report.
                    </p>
                    <p>
                        You have furthermore the right, without unreasonable delay to let us erase your personal data. You can only make use of this right to be erased in the following cases:
                    </p>
                    <ul>
                        <li>
                            When your personal data are no longer necessary for the purposes for which they were originally collected;
                        </li>
                        <li>
                            When your personal data were collected on the basis of a permission granted and there is no other legal basis for the processing;
                        </li>
                        <li>
                            When an objection is made against the processing and there are no prevailing compelling justified grounds for the processing to exist;
                        </li>
                        <li>
                            When the personal data were unlawfully processed;
                        </li>
                        <li>
                            When the personal data must be erased in accordance with a legal obligation.
                        </li>
                    </ul>
                    <p>SPATIE assesses the presence of one of the above-mentioned cases.</p>

                    <h3>Right on limitation of/objection to the processing of your personal data</h3>
                    <p>
                        The User has the right to obtain a limitation to the processing of your personal data:
                    </p>
                    <ul>
                        <li>
                            During the period that SPATIE needs to check the accuracy of the personal data, in the event of a dispute;
                        </li>
                        <li>
                            When the data processing is unlawful and the User requests for a limitation of the processing instead of erasing of personal data;
                        </li>
                        <li>
                            When SPATIE does no longer need the personal data for the processing purposes and the User needs the personal data for a legal proceeding;
                        </li>
                        <li>
                            During the period that SPATIE needs to assess the presence of the basis for the erasing of the personal data.
                        </li>
                    </ul>
                    <p>
                        The User has the right at all times to object to the processing of his personal data. SPATIE then ceases the processing of your personal data, unless SPATIE has compelling justified grounds for the processing of your personal data that can outweigh the User's right to object.
                    </p>
                    <p>
                        If the User wishes to exercise these rights, SPATIE will pursue the matter within one (1) month after receiving the request. The application is done via registered mail or by sending an e-mail to <a href="mailto:info@spatie.be">info@spatie.be</a>.
                    </p>

                    <h3>Right to data transferability</h3>
                    <p>
                        The User has the right to receive the personal data provided to SPATIE in a structured, common and machine-readable form. In addition, the User has the right to transfer this personal data to another controller when the processing of personal data solely rests on the permission obtained from the User.
                    </p>
                    <p>
                        If the User wishes to exercise these rights, SPATIE will pursue the matter within one (1) month after receiving the request. The application is done via registered mail or by sending an e-mail to <a href="mailto:info@spatie.be">info@spatie.be</a>.
                    </p>
                    <h3>Right on the withdrawal of my consent/right to complaint</h3>
                    <p>
                        The User has the right at all times to withdraw his consent. The withdrawal of the consent leaves the lawfulness of the processing on the basis of consent before the repeal of it without prejudice. In addition, the User has the right to file a complaint concerning the processing of his personal data by SPATIE with the Belgian Commission for the Protection of Privacy.
                    </p>
                    <p>
                        If the User wishes to exercise these rights, SPATIE will pursue the matter within one (1) month after receiving the request. The application is done via registered mail or by sending an e-mail to <a href="mailto:info@spatie.be">info@spatie.be</a>.
                    </p>
                </div>
            </div>
        </section>
    </div>

@endsection
