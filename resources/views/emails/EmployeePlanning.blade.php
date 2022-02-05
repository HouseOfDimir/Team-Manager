@component('mail::messageEmployee', ['title'       => $title,
                                     'firstName'   => $firstName,
                                     'name'        => $name
                                    ])
{{ $title }}

<p>
    Bonjour {{ $firstName . ' ' . $name }},<br /><br />
    Vous trouverez en fichier joint à ce mail, votre planning de la semaine du {{ $startDate }} au {{ $endDate }}
    Merci d'en prendre connaissance.
</p>

@endcomponent
