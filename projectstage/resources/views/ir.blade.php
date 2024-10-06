<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="{{ asset( 'css/bootstrap.min.css' ) }}">
    <title>ir</title>
</head>
<body class="p-2">
    @if(session('success'))
        <p class="alert alert-success">{{ session('success') }}</p>
    @endif
    <x-menu></x-menu>
    @php
        $empty = false;
    @endphp
    <x-tools page='ir' :activeData="$irData" :users="$users"></x-tools>
    <x-addform page='ir' :activeData="$irData" :users="$users" :clients="$clients"></x-addform>


    <table class="table table-hover text-center overflow-scroll" style="width :300%">
        <tr>
            @if(auth()->user()->role == 'Admin')
                <td colspan="3"></td>
            @else
                <td colspan="2"></td>
            @endif
            <td colspan="2" class="fw-bold fs-3">Janvier</td>
            <td colspan="2" class="fw-bold fs-3">Fevrier</td>
            <td colspan="2" class="fw-bold fs-3">Mars</td>
            <td colspan="2" class="fw-bold fs-3">Avril</td>
            <td colspan="2" class="fw-bold fs-3">Mai</td>
            <td colspan="2" class="fw-bold fs-3">Juin</td>
            <td colspan="2" class="fw-bold fs-3">Julliet</td>
            <td colspan="2" class="fw-bold fs-3">Aout</td>
            <td colspan="2" class="fw-bold fs-3">September</td>
            <td colspan="2" class="fw-bold fs-3">Octobre</td>
            <td colspan="2" class="fw-bold fs-3">Novembre</td>
            <td colspan="2" class="fw-bold fs-3">Decembre</td>
        </tr>
        <tr>
            <th>code client</th>
            <th style="width: 200px">entreprise</th>
            @if(auth()->user()->role == 'Admin')
                <th>collaborateur</th>
            @endif
            @for($i = 0 ; $i < 12 ; $i++)
                <th>date de depot</th>
                <th>numero de depot</th>
            @endfor
            
        </tr>
        @forelse ($irData as $ir)
        <tr>
            <td>{{$ir->clients->code}}</td>
            <td>{{$ir->clients->nom}}</td>
            @if(auth()->user()->role == 'Admin')
                <td>{{$ir->clients->users->name}}</td>
            @endif
            <x-monthcheck :activeData="$ir" page="ir"></x-monthcheck>
        </tr>
        @empty
            @php
                $empty=true;
            @endphp
        @endforelse
    </table>
    @if ($empty)
        <p class="text-center">Aucun resultat</p>
    @endif
</body>
</html>