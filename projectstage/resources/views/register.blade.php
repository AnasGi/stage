<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="{{ asset( 'css/bootstrap.min.css' ) }}"> 
    <link rel="icon" href="{{ asset('imgs/logo.png') }}" type="image/x-icon"> 
    <script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
    <title>Creer un nouvel utilisateur</title>
</head>
<body class="bg-light">

    <div class="container d-flex justify-content-center align-items-center vh-100">
        <div class="col-md-4">
            <div class="card shadow-sm">
                <div class="card-body">

                    <h3 class="text-center mb-4 fw-bold">
                        <img src="{{asset('imgs/newuser.png')}}" alt="" width="40">
                        Creer un collaborateur</h3>
                    <form action="{{route('register')}}" method="POST">
                        @csrf
                        @if (session('newUser'))
                            <p class="alert fw-bold alert-success alert-dismissible fade show" role="alert">{{ session('newUser') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </p>
                        @endif
                        <div class="form-group mb-3">
                            <label for="name" class="form-label">Nom</label>
                            <input type="text" class="form-control" id="name" name="name" placeholder="Entrer le nom de collaborateur" required>
                        </div>
                        <div class="form-group mb-3">
                            <label for="password" class="form-label">Mot de passe</label>
                            <input type="password" class="form-control" id="password" name="password" placeholder="Entrer le mot de passe de collaborateur" required>
                        </div>
                        <div class="form-group mb-3">
                            <label for="role" class="form-label">Rôle</label>
                            <select class="form-control" id="role" name="role" required>
                                <option value="">Choisir le role de collaborateur</option>
                                <option value="responsable">Responsable</option>
                                <option value="Admin">Admin</option>
                            </select>
                        </div>
                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-success fw-bold">Créer</button>
                            <a href="{{route('users.show')}}" class="btn btn-danger fw-bold">Fermer</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>
</html>