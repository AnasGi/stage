<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta htetat-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="{{ asset( 'css/bootstrap.min.css' ) }}">
    <title>etat</title>
</head>
<body class="p-2">
    @if(session('success'))
        <p class="alert fw-bold fs-5 alert-success">{{ session('success') }}</p>
    @endif
    <x-menu></x-menu>
    @php
        $empty = false;
    @endphp
    <x-tools page='etat' :activeData="$etatData" :users="$users"></x-tools>
    <x-addform page='etat' :activeData="$etatData" :users="$users" :clients="$clients"></x-addform>
    <x-alert :activeData="$etatData" page='etat'></x-alert>


    <table class="table table-bordered table-hover text-center overflow-scroll">
        <tr>
            <th>code client</th>
            <th style="width: 200px">entreprise</th>
            @if(auth()->user()->role == 'Admin')
                <th>collaborateur</th>
            @endif
            <th>date de depot</th>
            <th>numero de depot</th>
            
        </tr>
        @forelse ($etatData as $etat)
        <tr>
            <td>{{$etat->clients->code}}</td>
            <td>{{$etat->clients->nom}}</td>
            @if(auth()->user()->role == 'Admin')
                <td>{{$etat->clients->users->name}}</td>
            @endif
            <td>{{$etat->date_depot}}</td>
            <td>{{$etat->num_depot}}</td>
            <td><a href="{{route('etat.destroy' , $etat)}}" class="btn btn-danger" onclick="confirm('Vous-etre sure de supprimer cette donnée?')">supprimer</a></td>
            <td><a href="{{route('etat.update' , $etat)}}" class="btn btn-primary">modifier</a></td>
        </tr>
        @empty
            @php
                $empty=true;
            @endphp
        @endforelse
    </table>
    @if ($empty)
        <p class="text-center fw-bold fs-4 mt-5 text-danger">Aucune resultat !</p>
    @endif
</body>
</html>