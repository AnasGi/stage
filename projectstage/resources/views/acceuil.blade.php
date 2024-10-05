<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="{{ asset( 'css/bootstrap.min.css' ) }}">
    <title>Accueil</title>
</head>
<body class="p-2">

    @if(session('newUser'))
        <p class="alert alert-success">{{ session('newUser') }}</p>
    @endif

    @auth
        <x-menu></x-menu>
    @php
        $empty = false;
    @endphp
    @endauth

    @if (auth()->user()->role == 'Admin')
        <a href="{{route('register.form')}}">Creer un utilisateur</a>
        {{-- <a href="{{route('users.index')}}">Lise des responsables</a> --}}
    @endif

        
</body>
</html>