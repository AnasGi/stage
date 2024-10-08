<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="{{ asset( 'css/bootstrap.min.css' ) }}"> 
    <script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
    <title>Liste des clients</title>
</head>
<body class="p-2">
    @if(session('success'))
        <p class="alert fw-bold fs-5 alert-success alert-dismissible fade show" role="alert">{{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </p>
    @endif
    <x-menu></x-menu>
    @php
        $empty = false;
    @endphp

    <x-tools page='clients' :activeData="$clients" :users="$users"></x-tools>

    <x-addform page='clients' :activeData="$clients" :users="$users"></x-addform>


    <table class="table table-bordered table-hover text-center overflow-scroll" style="width :200%">
        <tr>
            <th style="width: 100px">code client</th>
            <th>entreprise</th>
            <th style="width: 100px">PM/PP</th>
            <th>adresse</th>
            <th>IF</th>
            <th>TP</th>
            <th>ICE</th>
            <th>CNSS</th>
            <th>RC</th>
            <th style="width: 200px">date debut d'activite</th>
            <th>activite</th>
            @if(auth()->user()->role == 'Admin')
                @if(auth()->user()->role == 'Admin')
                <th>collaborateur</th>
            @endif
            @endif
        </tr>
            @forelse ($clients as $client)
            <tr>
                <td>{{$client->code}}</td>
                <td>{{$client->nom}}</td>
                <td>{{$client->status}}</td>
                <td>{{$client->adresse}}</td>
                <td>{{$client->IF}}</td>
                <td>{{$client->TP}}</td>
                <td>{{$client->ICE}}</td>
                <td>{{$client->CNSS}}</td>
                <td>{{$client->RC}}</td>
                <td>{{$client->debut_activite}}</td>
                <td>{{$client->activite}}</td>
                @if(auth()->user()->role == 'Admin')
                    <td>{{$client->users->name}}</td>
                @endif
                <td><a href="{{route('clients.destroy' , $client)}}" class="btn btn-danger" onclick="confirm('Vous-etre sure de supprimer ce client, tous les données associées vont etre supprimer?')">supprimer</a></td>
                @if (auth()->user()->role == "Admin")
                    <td><a href="{{route('clients.update' , $client)}}" class="btn btn-primary">modifier</a></td>
                @endif
            </tr>
            @empty
                @php
                    $empty = true;
                @endphp
            @endforelse
    </table>
    @if ($empty)
    <p class="text-center">Aucun resultat</p>
    @endif
</body>
</html>