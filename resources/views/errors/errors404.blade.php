<link href="{{ asset('css/error404.css') }}" rel="stylesheet">

<div class="mars"></div>
<img src="{{ asset('image/404.svg') }}" class="logo-404" />
<img src="{{ asset('image/meteor.svg') }}" class="meteor" />
<p class="title">Oh non !!</p>
<p class="subtitle">
	Votre URL est incorrecte <br /> ou la page que vous demandez n'existe plus.
</p>
<div align="center">
	<a class="btn-back" href="{{ route('home') }}">Retour à l'accueil</a>
</div>
<img src="{{ asset('image/astronaut.svg') }}" class="astronaut" />
<img src="{{ asset('image/spaceship.svg') }}" class="spaceship" />
