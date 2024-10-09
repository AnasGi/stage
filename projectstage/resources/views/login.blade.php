<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="{{ asset( 'css/bootstrap.min.css' ) }}"> 
    <script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
    <title>Log in</title>
</head>
<body class="bg-light">
    
    <div class="container d-flex justify-content-center align-items-center vh-100">
        <div class="col-md-4">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h3 class="text-center mb-4">Authentification</h3>
                    @error('error')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                    <form action="{{route('login')}}" method="POST">
                        @csrf
                        <div class="form-group mb-3">
                            <label for="collaborateur" class="form-label">Nom d'utilisateur</label>
                            <input type="text" class="form-control" id="collaborateur" name="collaborateur" value="{{old('collaborateur')}}" placeholder="Enter your username" required>
                        </div>
                        <div class="form-group mb-3">
                            <label for="password" class="form-label">Mot de passe</label>
                            <input type="password" class="form-control" id="password" name="password" placeholder="Enter your password" required>
                        </div>
                        
                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary">Log In</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

</body>
</html>