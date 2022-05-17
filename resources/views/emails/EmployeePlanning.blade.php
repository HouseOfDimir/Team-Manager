@component('mail::messageEmployee', ['title'       => $title,
                                     'firstName'   => $firstName,
                                     'name'        => $name
                                    ])
{{ $title . ' du ' .$dateDebut. ' au ' .$dateFin}}

<p>
    Bonjour {{ $firstName . ' ' . $name }},<br /><br />
    Vous trouverez en fichier joint à ce mail, votre planning de la semaine du {{ $dateDebut }} au {{ $dateFin }}
    Merci d'en prendre connaissance.
</p>

@endcomponent
