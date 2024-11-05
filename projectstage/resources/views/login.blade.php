<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="{{ asset( 'css/bootstrap.min.css' ) }}"> 
    <link rel="icon" href="{{ asset('imgs/logo.png') }}" type="image/x-icon"> 
    <script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
    <title>Authentifier</title>
</head>
<body class="bg-light">
    
    <div class="container d-flex justify-content-center align-items-center vh-100">
        <div class="col-md-4">
            <div class="card shadow-sm">
                <div class="card-body">
                    <div class="d-flex justify-content-center m-2 mb-3">
                        <img src="{{asset('imgs/logo.png')}}" alt="logo"/>
                    </div>
                    @error('error')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                    <form action="{{route('login')}}" method="POST">
                        @csrf
                        <div class="form-group mb-3">
                            <label for="name" class="form-label">Nom d'utilisateur</label>
                            <input type="text" class="form-control" id="name" name="name" value="{{old('name')}}" placeholder="Saisir votre Nom d'utilisateur" required>
                        </div>
                        <div class="form-group mb-3">
                            <label for="password" class="form-label">Mot de passe</label>
                            <input type="password" class="form-control" id="password" name="password" placeholder="Saisir votre mot de pass" required>
                        </div>
                        
                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary fw-bold">Authentifier</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

</body>
</html>