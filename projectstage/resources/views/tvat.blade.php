<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta httvat-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="{{ asset( 'css/bootstrap.min.css' ) }}">
    <title>tvat</title>
</head>
<body class="p-2">
    @if(session('success'))
        <p class="alert fw-bold fs-5 alert-success">{{ session('success') }}</p>
    @endif
    <x-menu></x-menu>
    @php
        $empty = false;
    @endphp
    <x-tools page='tvat' :activeData="$tvatData" :users="$users"></x-tools>
    <x-addform page='tvat' :activeData="$tvatData" :users="$users" :clients="$clients"></x-addform>
    <x-alert :activeData="$tvatData" page='tvat'></x-alert>

    <table class="table table-bordered table-hover text-center overflow-scroll" style="width :150%">
        <tr>
            @if(auth()->user()->role == 'Admin')
                <td colspan="3"></td>
            @else
                <td colspan="2"></td>
            @endif
            <td colspan="2" class="fw-bold fs-3">1ere trimestre </td>
            <td colspan="2" class="fw-bold fs-3">2ere trimestre </td>
            <td colspan="2" class="fw-bold fs-3">3ere trimestre </td>
            <td colspan="2" class="fw-bold fs-3">4ere trimestre </td>
        </tr>
        <tr>
            <th>code client</th>
            <th style="width: 200px">entreprise</th>
            @if(auth()->user()->role == 'Admin')
                <th>collaborateur</th>
            @endif
            @for($i = 0 ; $i < 4 ; $i++)
                <th>date de depot</th>
                <th>numero de depot</th>
            @endfor
            
        </tr>
        @forelse ($tvatData as $tvat)
        <tr>
            <td>{{$tvat->clients->code}}</td>
            <td>{{$tvat->clients->nom}}</td>
            @if(auth()->user()->role == 'Admin')
                <td>{{$tvat->clients->users->name}}</td>
            @endif
            <x-monthcheck :activeData="$tvat"  page="tvat"></x-monthcheck>
            <td><a href="{{route('tvat.destroy' , $tvat)}}" class="btn btn-danger" onclick="confirm('Vous-etre sure de supprimer cette donnée?')">supprimer</a></td>
            <td><a href="{{route('tvat.update' , $tvat)}}" class="btn btn-primary">modifier</a></td>
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