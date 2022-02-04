@component('mail::message', ['title'       => $title,
                             'firstName'   => $firstName,
                             'name'        => $name,
                             'birthDate'   => $birthDate,
                             'birthPlace'  => $birthPlace,
                             'greenNumber' => $greenNumber,
                             'phone'       => $phone,
                             'mail'        => $mail,
                             'adress'      => $adress,
                             'zipCode'     => $zipCode,
                             'city'        => $city
                            ])
{{ $title }}

<p>
    Bonjour, vous trouverez ci-dessous les informations relatives à un(e) employé(e) dans le cadre de l'édition d'un contrat.
</p>

@endcomponent
