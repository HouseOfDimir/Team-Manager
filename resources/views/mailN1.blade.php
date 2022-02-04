<html>
<head>
    <title></title>
</head>
<body>
    <h1>{{ $details['title'] }}</h1>
    <div class="col-md-12">
        <div class="a-panel a-panel-light a-box-shadow">
            <div class="a-panel-header">
                <div class="row">
                    <div class="col-md-12">{{ $details['firstName'] . ' ' . $details['name'] }}</div>
                </div>
            </div>
            <div class="a-panel-content">
                <div class="row">
                    <div class="col-md-6 col-md-offset-1 a-input-group">
                        <input class="a-input" value="{{ $details['birthDate'] }}" disabled />
                        <label><i class="far fa-address-card"></i> Né(e) le:</label>
                    </div>
                    <div class="col-md-6 col-md-offset-1 a-input-group">
                        <input class="a-input" value="{{ $details['birthPlace'] }}" disabled />
                        <label><i class="far fa-address-card"></i> A:</label>
                    </div>
                    <div class="col-md-6 col-md-offset-1 a-input-group">
                        <input class="a-input" value="{{ $details['greenNumber'] }}" disabled />
                        <label><i class="far fa-address-card"></i> Numéro sécurité sociale</label>
                    </div>
                    <div class="col-md-6 col-md-offset-1 a-input-group">
                        <input class="a-input" value="{{ $details['adress'] }}" disabled />
                        <label><i class="far fa-address-card"></i> Adresse</label>
                    </div>
                    <div class="col-md-6 col-md-offset-1 a-input-group">
                        <input class="a-input" value="{{ $details['city'] }}" disabled />
                        <label><i class="far fa-address-card"></i> Ville</label>
                    </div>
                    <div class="col-md-6 col-md-offset-1 a-input-group">
                        <input class="a-input" value="{{ $details['zipCode'] }}" disabled />
                        <label><i class="far fa-address-card"></i> Code postal</label>
                    </div>
                    <div class="col-md-6 col-md-offset-1 a-input-group">
                        <input class="a-input" value="{{ $details['mail'] }}" disabled />
                        <label><i class="far fa-address-card"></i> Mail</label>
                    </div>
                    <div class="col-md-6 col-md-offset-1 a-input-group">
                        <input class="a-input" value="{{ $details['phone'] }}" disabled />
                        <label><i class="far fa-address-card"></i> Téléphone</label>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
