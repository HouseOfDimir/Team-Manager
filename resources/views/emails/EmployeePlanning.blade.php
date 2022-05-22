@component('mail::messageEmployee', ['title'       => $title,
                                     'firstName'   => $firstName,
                                     'name'        => $name
                                    ])
{{ $title . ' du ' .$dateDebut. ' au ' .$dateFin}}

<p>
    Bonjour {{ $firstName . ' ' . $name }},<br /><br />
    Vous trouverez en fichier joint à ce mail, votre planning de la semaine du {{ $dateDebut }} au {{ $dateFin }}.<br />
    Merci d'en prendre connaissance.
</p>

<p>
    <i>Ceci est un mail automatique de l'application <b>{{ config('app.name') }}</b>, veuillez ne pas y répondre.</i>
</p>

@endcomponent
