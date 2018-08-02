@extends('layout.default', [
    'background' => '/backgrounds/legal.jpg',
    'title' => 'General conditions',
    'description' => 'Our general terms and conditions for clients.',
    ])

@section('content')

    <section id="banner" class="banner" role="banner">
        <div class="wrap">
            <h1 class="banner-slogan">
                General terms <br>
                and conditions
            </h1>
            <p class="mt-4">
                <span class="icon mr-2 opacity-50 fill-blue">{{ svg('icons/far-angle-left') }}</span> <a href="{{ route('legal.index')}}" class="link-underline link-blue">Legal overview</a>
            </p>
        </div>
    </section>
    <div class="section-group pt-0">
        <section class=section>
            <div class="wrap">
                <div class="markup markup-lists markup-titles links-underline links-blue">
                    <h2 id="toc">Table of contents</h2>
                    <ol class="counters-upper-roman leading-loose">
                        <li><a href="#chapter-1">General sales conditions</a></li>
                        <li><a href="#chapter-2">Development & maintenance of websites & software</a></li>
                        <li><a href="#chapter-3">Web hosting</a></li>
                        <li><a href="#chapter-4">Registration of domain names</a></li>
                    </ol>
                </div>
            </div>
        </section>
        <section class=section>
            <div class="wrap">
                <div class="markup markup-titles counters markup-lists links-underline links-blue">
                    <h1 id="chapter-1">General sales conditions</h1>

                    <h2>Applicability</h2>

                    <ol class="counters-level-2">
                        <li>
                            The general terms and conditions apply to all legal actions and legal relationships between SPATIE and the client, unless otherwise explicitly agreed upon in writing between both parties.
                        </li>
                        <li>
                            The client shall be deemed to have agreed tacitly with the exclusive applicability of these conditions with any order given orally, written, by telephone, by e-mail, by telex or by telefax or otherwise, regardless of a written confirmation of SPATIE.
                        </li>
                        <li>
                            No other specification, description, publication, written or oral commitment, will be part of these conditions nor will it be deemed to have references to them in these conditions.
                        </li>
                        <li>
                            Any purchase, payment or other terms and conditions of the client shall not apply, unless they have been accepted expressly in writing by SPATIE, even if the conditions of the client exclude these conditions.
                        </li>
                        <li>
                            All quotations and offers made by or on behalf of SPATIE are without engagement and may be withdrawn by SPATIE as long as SPATIE has not accepted the order or task following a quotation or offer  in writing. All quotations and offers are also subject to amendments of the order by the client or due to price changes from the suppliers.
                        </li>
                        <li>
                            SPATIE reserves the right to refuse any order or task without giving any reason.
                        </li>
                        <li>
                            The placing of an order or task with SPATIE is valid as the acceptance of these general sales conditions, to be consulted on the SPATIE website at <a href="https://spatie.be/legal">https://spatie.be/legal</a>.
                        </li>
                        <li>
                            The person placing the order or task in the name of the client is assumed as being authorised. He bears together with his principal all possible responsibility vis-à-vis third parties.
                        </li>
                    </ol>

                    <h2>Prices, tariffs and payment</h2>

                    <ol class="counters-level-2">
                        <li>All prices and tariffs of SPATIE are exclusive of VAT, unless expressly stated otherwise.
                        </li>
                        <li>
                            Save as otherwise provided for and express agreement, there will be a 30% deposit
                            paid to SPATIE on the total amount, including VAT, for each order by the client
                            before it starts with the performance of the task and/or order.
                        </li>
                        <li>
                            Parties may, for the execution of the work agree on a fixed price. Fixed prices are
                            prices that during the execution of the agreed work are not subject to change, with the
                            exception of what is determined in the general terms and conditions.

                        </li>
                        <li>
                            If no fixed price is agreed with regard to the execution of the work, SPATIE will charge the hours spent and costs incurred monthly to the client on the basis of the agreed rates or the rates into force since the time of the agreement.

                        </li>
                        <li>
                            All invoices are payable at the due date being, subject to different contractual clauses,
                            thirty days after the invoice date, or cash on delivery or completion of the work, according
                            to the clear    indication on the invoice which present conditions form an integrated part.

                        </li>
                        <li>
                            All payments must be made without deduction or set-off by bank transfer to the bank account
                            of SPATIE mentioned on the invoice, or by cash payment to one of the directors of SPATIE.

                        </li>
                        <li>
                            Non-payment on the due date shall automatically and without notice make an obligation at the
                            expense of the client of an interest on the outstanding amount to be paid per day of
                            delay at a rate of 15% on an annual basis. In addition to the delay interest, in the absence
                            of paymenton the due date, immediately and without prior notice the invoice amounts
                            will be increased by 10%, with a minimum of €50, in title of a lumpsum established and expressly agreed damage compensation between both parties for additional administrative and legal costs.

                        </li>
                        <li>
                            In the event of non-payment SPATIE reserves the right to temporarily suspend or permanently
                            cancel any subscriptions to services of SPATIE, even on its sold, rented or managed
                            webhosting, websites, trainings, etc.

                        </li>
                        <li>
                            In the event of non-payment of one of the outstanding invoices, SPATIE reserves the right
                            expressly for the immediate and full payment of all claims that are in its possession at that
                            time vis-a-vis the client and to suspend each running order or agreement.

                        </li>
                        <li>
                            If the client fails to comply with his obligations, SPATIE is authorised to suspend its work
                            and to charge the costs incurred at that time to the client.

                        </li>
                        <li>
                            Any complaint will be thoroughly investigated by SPATIE if, at the risk of cancellation, it is
                            submitted by registered letter within 8 days after delivery of the goods and/or services.

                        </li>
                        <li>
                            Complaints of the client on the invoice received must be remitted to SPATIE by registered letter within eight days, otherwise they are null and void. The written complaint must clearly
                            state what amount and invoice components are disputed. The non-disputed amounts
                            must always be paid within the terms of payment of the invoice.
                        </li>
                        <li>
                            The amounts stated in these provisions are in euro and exclusive of 21% VAT.
                        </li>
                    </ol>

                    <h2>Cancellation</h2>

                    <ol class="counters-level-2">
                        <li>
                            <p>
                                Orders and tasks can only be cancelled if and to the extent that all the following conditions are met:
                            </p>
                            <ol class="counters-lower-alpha">
                                <li>
                                    SPATIE expressly agrees in writing with the cancellation.
                                </li>
                                <li>
                                    The cancellation must take place before the delivery took place or before SPATIE in any form or capacity has begun with the agreed work.
                                </li>
                                <li>
                                    Orders of domain name registrations and extensions of domain names, through whatever means, can never be cancelled.
                                </li>
                            </ol>
                        </li>
                    </ol>

                    <h2>Implementation</h2>

                    <ol class="counters-level-2">
                        <li>
                            If it is agreed that the work will take place in phases, SPATIE can delay the start of the
                            services belonging to a following phase, until the client has approved the results of the
                            preceding phase in writing.
                        </li>
                        <li>
                            If the execution of an order or task, at the request of the client, should be discontinued
                            for an indefinite time and this brings about additional costs, these will always be at the
                            expense of the client.
                        </li>
                        <li>
                            If the client wishes to change or expand the task given in the agreement, this can only take
                            place after both sides have confirmed in writing their agreement about the changes and
                            the impact on the price and the delivery date.
                        </li>
                        <li>
                            Subject to prior agreement SPATIE is not committed to keep photos, designs, pictures,
                            photos, films, logos, html documents, etc., either digital or analogue.
                        </li>
                    </ol>

                    <h2>Changes and additional work</h2>

                    <ol class="counters-level-2">
                        <li>
                            Under additional work shall be understood any amendment to the functional specifications laid out in the original agreement, or specifications agreed on afterwards, regardless of at what moment.
                        </li>
                        <li>
                            SPATIE will notify the client as soon as possible when a change by an intermediate party, because of a to be agreed upon change or supplement to the specifications, will affect the time of completion of the work.
                        </li>
                        <li>
                            If a fixed price was agreed for the work, SPATIE will inform the client in advance if the to be agreed upon change or supplement to the work will have as a result that the agreed price will be exceeded. Unless an objection is submitted in writing, the client will be presumed to have agreed with the additional work.
                        </li>
                        <li>
                            Necessity or desirability of additional work can never be a reason to dissolve the agreement.
                        </li>
                    </ol>

                    <h2>Time limits</h2>

                    <ol class="counters-level-2">
                        <li>
                            Any time limits when ordering or placing the tasks will run from the working day following the issue of the necessary documents or from the signature of the agreement.
                        </li>
                        <li>
                            The agreed delivery period is prolonged to the extent that the client, when issuing the documents, drawings, pictures, models, photographs, texts, and so on, as well as when returning corrected tests or delaying meetings, has remained in default.
                        </li>
                        <li>
                            If exceeding the time limit (of delivery) takes place, SPATIE will notify the client as soon as
                            possible.
                        </li>
                        <li>
                            Because the delivery time can be affected by actions of third parties and cases of force majeure, they are not regarded as explicit commitment. Late delivery may, subject to conflicting clause, not give rise to refusal of the delivery and will not give rise to any compensation.
                        </li>
                        <li>
                            Exceeding of the time limit will never give the client the right to dissolution and/or suspension of his obligations under other contracts.
                        </li>
                    </ol>

                    <h2>Confidentiality</h2>

                    <ol class="counters-level-2">
                        <li>
                            Each party will take all reasonable precautions in order to keep confidential information received about the other party secret.
                        </li>
                    </ol>

                    <h2>Ownership and protection</h2>

                    <ol class="counters-level-2">
                        <li>
                            Affairs remain the property of SPATIE until all relevant amounts due by the client are met.
                        </li>
                        <li>
                            Business and software are, from the moment they have been made available by SPATIE to the client, for his account and risk.
                        </li>
                    </ol>

                    <h2>Liability</h2>

                    <ol class="counters-level-2">
                        <li>
                            SPATIE accepts legal obligations relating to common law damages as far as that is evident from this article 9.
                        </li>
                        <li>
                            <p>In the case of chargeable shortcoming in the performance of the contract, SPATIE is only liable for replacement compensation, i.e. compensation for the value of the performance, remaining in arrears, or (partial) refund of the price received for the non-conforming part of the assignment. Any liability of SPATIE for any other form of damage is excluded, including additional damages in whatever form, compensation for indirect damage or consequential loss or damage due to lost profits. SPATIE is in no way liable for delay damages, damages for loss of data, damage due to exceeding the delivery deadline due to changed circumstances, damage as a result of the acquiring of inadequate cooperation, information or materials by the client, and the damage as a result of information provided by SPATIE and advises whose contents are not explicitly part of a written agreement. Defects in the materials that were stored by SPATIE, will not compromise its responsibility and cannot cause a demand on damage-compensation.
                            </p>
                        </li>
                        <li>
                            Condition for any right to compensation is always that the client, after the damage has occurred, within a period of two weeks, reports it by registered mail to SPATIE.
                        </li>
                        <li>
                            SPATIE is not liable for errors or defects if these are due to software or hardware or other materials that were not delivered by SPATIE and that are defective and/or of which SPATIE didn't know that they would be used along with the products/services delivered by them, or the fact that others than SPATIE have made changes to the products/services.
                        </li>
                        <li>
                            The client indemnifies SPATIE for all damage that SPATIE may suffer as a result of third-party liability related to the goods or services supplied by SPATIE, including:
                            <ul>
                                <li>
                                    claims of third parties, including employees of the client, who suffer damage arising out of wrongful actions by employees of SPATIE that were put at the disposal of the client and work under his supervision or on his indications;
                                </li>
                                <li>
                                    claims of third parties, including employees of SPATIE, that in connection with the performance of the contract suffer injury arising out of actions or omissions of the client or of unsafe situations in his company;
                                </li>
                                <li>
                                    claims by third parties who suffer damage arising out of a defect in products and services delivered by SPATIE if the defect in the materials was hidden from SPATIE.
                                </li>
                            </ul>
                        </li>
                        <li>
                            The client is responsible for the use and the correct application in his organisation of the equipment, the software and the services to be provided by SPATIE.
                        </li>
                    </ol>

                    <h2>Dissolution, termination and suspension</h2>

                    <ol class="counters-level-2">
                        <li>
                            If the client fails to fulfil one of his obligations towards SPATIE, requests the cessation of payment or is in a state of bankruptcy, SPATIE has the right without further notice of default or judicial intervention being required, to dissolve, all or certain, at the choice of SPATIE, agreements concluded with the client, without prejudice to other legal rights due to SPATIE. All payments due shall become immediately due and payable.
                        </li>
                        <li>
                            When the client does not fulfil any obligations resting on him on the basis of these general conditions or an agreement concluded with SPATIE, then SPATIE, without prejudice to its other rights, is entitled to suspend the agreed work until the client complies with his obligations.
                        </li>
                    </ol>

                    <h2>Intellectual and industrial property rights </h2>

                    <ol class="counters-level-2">
                        <li>
                            The client acknowledges that SPATIE is the exclusive owner or licensee of all trademarks, patents or copyright attached to all products and services delivered by SPATIE. The client agrees that for the duration of the agreement and thereafter, he will not challenge any intellectual and/or industrial property right of which SPATIE is the owner or licensee.
                        </li>
                    </ol>

                    <h2>Applicable law and disputes</h2>

                    <ol class="counters-level-2">
                        <li>
                            The agreement between SPATIE and the client shall be governed by Belgian law.
                        </li>
                        <li>
                            All disputes relating to these terms and conditions or agreements concluded by a SPATIE will always be decided by the courts of the district of Antwerp, Belgium.
                        </li>
                    </ol>

                    <p class="mt-16">
                        <a href="#toc">Table of contents &uarr;</a>
                    </p>

                    <h1 id="chapter-2">Development & maintenance of websites & software</h1>

                    <h2>Subject of the agreement</h2>

                    <ol class="counters-level-2">
                        <li>
                            The conditions mentioned under paragraph II are specific to all the work to be performed by SPATIE for the benefit of the client relating to the development and maintenance of web sites and software on the basis of detailed specifications and functional requirements.
                        </li>
                        <li>
                            The conditions mentioned under paragraph II are in addition to the terms and condition
                            stated in paragraph I.
                        </li>
                    </ol>

                    <h2>Implementation</h2>

                    <ol class="counters-level-2">
                        <li>
                            On the basis of the information to be provided by the client, for the accuracy and completeness for which the client is responsible, will be specified in writing which website/software will be developed.
                        </li>
                        <li>
                            SPATIE is responsible for the correction of errors due to them. Authors improvements that results in changes, additions or omissions beyond our control, will be charged according to the current rates.
                        </li>
                    </ol>

                    <h2>Delivery and acceptance</h2>

                    <ol class="counters-level-2">
                        <li>
                            SPATIE will deliver the developed websites and/or software to the client in accordance with the specifications.
                        </li>
                        <li>
                            The client has the right to test the website/software for a period of 8 days of user ready delivery. Purpose of the test is to determine whether the website/software complies with the agreed specifications.
                        </li>
                        <li>
                            If, during the carrying out the acceptance test it is evident that the website/software shows defects or does not satisfy the written specifications, the client will inform SPATIE immediately in a written and detailed acceptance report of the defects. SPATIE will in that case restore the reported deficiencies within a reasonable time. The repair shall be free if the software was developed for a fixed price.
                        </li>
                        <li>
                            Small defects that do not stand in the way of operational commissioning are no reason to refuse the acceptance. When actually using the website/software or parts thereof, the client has accepted the website/software or these parts.
                        </li>
                        <li>
                            The website/software is further deemed to have been accepted after acceptance by the client, or 8 days after the ready for use delivery if the client has not informed SPATIE in writing about the defects, or after the repair of the reported defects.
                        </li>
                        <li>
                            The acceptance cannot not be held back by the client because of the failure to perform an acceptation test in whole or partly by the client.
                        </li>
                        <li>
                            As far as a phased delivery is agreed, all points of this section apply without prejudice for the
                            parts corresponding with the phasing of the project.
                        </li>
                    </ol>

                    <h2>Ownership and protection</h2>

                    <ol class="counters-level-2">
                        <li>
                            In accordance with the legal provisions on artistic and industrial ownership, drawings, models, designs, and so on, all the sketches, designs, photos, pictures, web pages and web sites, banners, interpretations, concepts, solutions, software, etc…, designed by SPATIE whatever the technique may be, are the property of SPATIE. They should in no way be counterfeited or reproduced or distributed in anyway whatsoever. The reneging or the cession of the above must in no way, unless permitted expressly and in advance, be regarded as the right to ownership.
                        </li>
                        <li>
                            The designed website/software is the intellectual property of SPATIE and as such protected by the law. The website/software can therefore not be transferred free of charge or with a considered title, in whatever form, in whole or in part, to any third party, subject to the express written permission of SPATIE.
                        </li>
                        <li>
                            The client undertakes to maintain the confidentiality of the website/software, and not to distribute copies of whole or parts of the software or of methods and concepts used therein to any third party.
                        </li>
                        <li>
                            All the elements and data provided by the client to SPATIE are provided for inclusion in the website/software, including all texts, images, logos, graphics, photos, audio or video films and the updates are supposed to be and to remain the exclusive property of the client.
                        </li>
                        <li>
                            To the extent that all or part of these elements are not the exclusive property of the client, the client guarantees that he has all the necessary permissions for the use of these elements. These permissions should, as appropriate, refer to:

                            <ul>
                                <li>
                                    the right of reproduction on any digital or other carrier, including the right to the adjustment needed    for the transfer from one carrier to the other;
                                </li>
                                <li>
                                    the right to the graphical adjustment on every carrier;
                                </li>
                                <li>
                                    the right to electronic distribution as well as, where applicable, the right to distribute the carrier that contains these elements;
                                </li>
                                <li>
                                    the right of communication to the public, with or without reserve, with any means, such as cable, satellites, internet, including the provision to the public of the elements in such a way that everyone has access to it at the place and time that he individually choses.
                                </li>
                            </ul>
                        </li>
                        <li>
                            The client indemnifies SPATIE against all third-party complaints that would claim a right to intellectual property or other contradictory right to any of the elements or data provided under article 4.4.
                        </li>
                    </ol>

                    <p class="mt-16">
                        <a href="#toc">Table of contents &uarr;</a>
                    </p>

                    <h1 id="chapter-3">Web hosting</h1>

                    <h2>Subject of the agreement</h2>

                    <ol class="counters-level-2">
                        <li>
                            The conditions listed under paragraph III are valid specifically to all web hosting activities for the benefit of the client to be performed by SPATIE. Web hosting refers to the putting out of a website on a webserver.
                        </li>
                        <li>
                            The conditions listed under paragraph III are an addition to the general conditions listed under paragraph I.
                        </li>
                    </ol>

                    <h2>Ownership and protection</h2>

                    <ol class="counters-level-2">
                        <li>
                            All the elements and data of the website that are provided by the client to SPATIE
                            for placement on a webserver, including all texts, images, logos, graphics, photos, audio or
                            video films and the updates are supposed to be and remain the exclusive property of the
                            client.
                        </li>
                        <li>
                            To the extent that all or part of these elements are not the exclusive property of the client,
                            the client guarantees that he has all the necessary permissions for use of these elements.
                            These permissions should, as appropriate, refer to:

                            <ul>
                                <li>
                                    the right of reproduction on any digital or other carrier, including the right to the adjustment needed for the transfer from one carrier to the other;
                                </li>
                                <li>
                                    the right to the graphical adjustment on every carrier;
                                </li>
                                <li>
                                    the right to electronic distribution as well as, where applicable, the right to distribute the carrier that contains these elements;
                                </li>
                                <li>
                                    the right of communication to the public, with or without reserve, with any means, such as cable, satellites, internet, including the provision to the public of the elements in such a way that everyone has access to it at the place and time that he individually choses.
                                </li>
                            </ul>
                        </li>
                        <li>
                            The client indemnifies SPATIE against all third-party complaints that would claim a right to
                            intellectual property or other contradictory right to any of the elements or data provided
                            under article 2.1.
                        </li>
                        <li>
                            The client is committed to the fact that the owner of the rights to these elements, for the entire duration of the order, waives his right to oppose changes to these elements or against their association with other texts, declarations, elements, etc. The client accepts that SPATIE according to the technical requirements can change the stored elements. This without prejudice to any right of the author to oppose changes that could harm his honour or his good name.
                        </li>
                        <li>
                            The client accepts that SPATIE can carry out all actions necessary for the implementation
                            of the webhosting service.

                            <ul>
                                <li>
                                    Copy the data and/or elements and the updates of it; both permanent and temporary, regardless of the form or the carrier (including electronic);
                                </li>
                                <li>
                                    inform and/or put these at the disposal of the internet users.
                                </li>
                            </ul>
                        </li>
                    </ol>

                    <h2>Duration of the agreement</h2>

                    <ol class="counters-level-2">
                        <li>
                            A web hosting is offered for a period of 1 year, unless otherwise agreed. Except for written
                            notice, the period at expiry of that period is automatically extended for a period of 1 year.
                            The client is committed to respect 3 months’ notice in writing, which 3 months takes place before the end of the subscription day or during the initial period or during the period of
                            extension.
                        </li>
                    </ol>

                    <p class="mt-16">
                        <a href="#toc">Table of contents &uarr;</a>
                    </p>

                    <h1 id="chapter-4">Registration of domain names</h1>

                    <h2>Subject of the agreement</h2>

                    <ol class="counters-level-2">
                        <li>
                            The conditions mentioned under paragraph IV are specifically valid to all activities to be carried out by SPATIE for the benefit of the client concerning registration, transfer or trade domain names.
                        </li>
                        <li>
                            The conditions listed under paragraph IV  are an addition to the general provisions listed under paragraph I.
                        </li>
                    </ol>


                    <h2>Registration</h2>

                    <ol class="counters-level-2">
                        <li>
                            Each registration of any domain commits the client irrevocably.
                        </li>
                    </ol>

                    <h2>Responsibility</h2>

                    <ol class="counters-level-2">
                        <li>
                            Since the award of the domain names on the internet depends on the express approval of the competent authority, SPATIE is at no time responsible for any refusal. Also damages compensation do not exist.
                        </li>
                    </ol>

                    <h2>Duration of the agreement</h2>

                    <ol class="counters-level-2">
                        <li>
                            The registration of a domain name is always for a period of 1 year, unless otherwise agreed. Except for written notice, the domain name  will at expiry automatically be extended for a period of 1 year. The client undertakes to respect the 2 months ' notice period in writing, which shall be done 2 months before the end of the subscription day, be it during the initial period or during the period of extension.
                        </li>
                        <li>
                            Invoices for the registration of one or more domain names are always payable within 8 calendar days after the date of invoice unless otherwise stated on the invoice.
                        </li>
                    </ol>

                    <h2>Name servers</h2>

                    <ol class="counters-level-2">
                        <li>
                            The client undertakes, when requested by SPATIE, to provide the domain name or to let it be provided with at least two name servers which in turn are configured correctly, to direct data traffic via the domain name in the correct lane. He will under no circumstances cancel the name servers of SPATIE if he does not rent a corresponding web hosting package with SPATIE.
                        </li>
                    </ol>

                    <h2>Email address</h2>

                    <ol class="counters-level-2">
                        <li>
                            The client will with the registration of the domain name, in addition to the other required data, notify the name, telephone number and e-mail address of the contact person. This e-mail address should be functional at all times and not be involved on one of the domain names that are rented with SPATIE by any client. The client shall at all times comply with the requirements of this e-mail-address, and will, if necessary, pass on a change of e-mail address to SPATIE.
                        </li>
                    </ol>

                    <h2>Modalities</h2>

                    <ol class="counters-level-2">
                        <li>
                            The client takes note of the fact that SPATIE acts only as an intermediary between the client and the authority that assigns the domain name. Applying and maintaining the domain name needs is simply and only to be considered as an additional client service. The client acknowledges that SPATIE has no decisive control over requesting, recording, adjusting, maintaining or cancelling a domain name, in particular with regards the regulation which is handled by ICANN, OpenSRS, DNS BE or any other relevant authority. SPATIE will in no way be held liable if the client loses control of the domain name as a result of such regulations or any other reason. SPATIE will for that matter always seek to defend the interests of the client.
                        </li>
                    </ol>

                    <p class="mt-16">
                        <a href="#toc">Table of contents &uarr;</a>
                    </p>

                </div>
            </div>
        </section>
    </div>

@endsection
