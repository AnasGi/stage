<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta htpv-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="{{ asset( 'css/bootstrap.min.css' ) }}">
    <title>pv</title>
</head>
<body class="p-2">
    @if(session('success'))
        <p class="alert fw-bold fs-5 alert-success">{{ session('success') }}</p>
    @endif
    <x-menu></x-menu>
    @php
        $empty = false;
    @endphp
    <x-tools page='pv' :activeData="$pvData" :users="$users"></x-tools>
    <x-addform page='pv' :activeData="$pvData" :users="$users" :clients="$clients"></x-addform>
    <x-alert :activeData="$pvData" page='pv'></x-alert>


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
        @forelse ($pvData as $pv)
            <tr>
                <td>{{$pv->clients->code}}</td>
                <td>{{$pv->clients->nom}}</td>
                @if(auth()->user()->role == 'Admin')
                    <td>{{$pv->clients->users->name}}</td>
                @endif
                <td>{{$pv->date_depot}}</td>
                <td>{{$pv->num_depot}}</td>
                <td><a href="{{route('pv.destroy' , $pv)}}" class="btn btn-danger" onclick="confirm('Vous-etre sure de supprimer cette donnée?')">supprimer</a></td>
            <td><a href="{{route('pv.update' , $pv)}}" class="btn btn-primary">modifier</a></td>
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