<div class="col-md-12">
    <div class="a-panel a-panel-light a-box-shadow">
        <div class="a-panel-header">
            <div class="row">
                <div class="col-md-12">{{ $firstName . ' ' . $name }}</div>
            </div>
        </div>
        <div class="a-panel-content">
            <div class="row">
                <div class="mt-1">
                    <b>Date de naissance: </b>{{ $birthDate }}
                </div>
                <div class="mt-1">
                    <b>Lieu de naissance: </b>{{ $birthPlace }}
                </div>
                <div class="mt-1">
                    <b>Numéro de sécurité sociale: </b>{{ $greenNumber }}
                </div>
                <div class="mt-1">
                    <b>Adresse: </b>{{ $adress }}
                </div>
                <div class="mt-1">
                    <b>Ville/Commune: </b>{{ $city }}
                </div>
                <div class="mt-1">
                    <b>Code postal: </b>{{ $zipCode }}
                </div>
                <div class="mt-1">
                    <b>Adresse mail: </b>{{ $mail }}
                </div>
                <div class="mt-1">
                    <b>Numéro de téléphone: </b>{{ $phone }}
                </div>
            </div>
        </div>
    </div>
</div>

Ceci est un mail automaatique de l'application <b>{{ config('app.name') }}</b>, veuillez ne pas y répondre.
