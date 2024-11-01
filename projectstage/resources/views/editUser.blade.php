<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="{{ asset( 'css/bootstrap.min.css' ) }}"> 
    <script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
    <title>Modifier votre coordonnées</title>
</head>
<body>
    <div class="container d-flex justify-content-center align-items-center vh-100">
        <div class="col-md-4">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h3 class="text-center mb-4">Modifier l'utilisateur</h3>
                    <form action="{{ route('user.update', $user) }}" method="POST">
                        @csrf
                        @method('put')

                        @if (session('userMod'))
                            <p class="alert fw-bold alert-success alert-dismissible fade show" role="alert">{{ session('userMod') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </p>
                        @endif
    
                        <div class="form-group mb-3">
                            <label for="username" class="form-label">Nom d'utilisateur</label>
                            <input type="text" class="form-control" id="username" name="name" placeholder="Entrez le nom d'utilisateur" value="{{ $user->name }}">
                        </div>
                        @error('name')
                            <p class="text-danger fs-6">Le nom d'utilisateur doit etre entre 4 et 30 caractéres</p>
                        @enderror
    
                        <div class="form-group mb-3">
                            <label for="password" class="form-label">Mot de passe</label>
                            <input type="password" class="form-control" id="password" name="password" placeholder="Entrez un nouveau mot de passe">
                        </div>
                        @error('password')
                            <p class="text-danger fs-6">Le mot de passe doit etre entre 4 et 30 caractéres</p>
                        @enderror
    
                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary">Modifier</button>
                            <a href="{{route('clients.index')}}" class="btn btn-danger">Fermer</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    
      
</body>
</html>