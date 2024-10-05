<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="{{ asset( 'css/bootstrap.min.css' ) }}">
    <title>acompte</title>
</head>
<body class="p-2">
    @if(session('success'))
        <p class="alert alert-success">{{ session('success') }}</p>
    @endif
    <x-menu></x-menu>
    @php
        $empty = false;
    @endphp

    <x-tools page='acompte' :activeData="$acompteData" :users="$users"></x-tools>


    <table class="table table-hover text-center overflow-scroll" style="width :150%">
        <tr>
            @if(auth()->user()->role == 'Admin')
                <td colspan="3"></td>
            @else
                <td colspan="2"></td>
            @endif
            <td colspan="2" class="fw-bold fs-3">Regularisation </td>
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
            @for($i = 0 ; $i < 5 ; $i++)
                <th>date de depot</th>
                <th>numero de depot</th>
            @endfor
            
        </tr>
        @forelse ($acompteData as $acompte)
        <tr>
            <td>{{$acompte->clients->code}}</td>
            <td>{{$acompte->clients->nom}}</td>
            @if(auth()->user()->role == 'Admin')
                <td>{{$acompte->clients->users->name}}</td>
            @endif
            <x-monthcheck :activeData="$acompte" page="acompte"></x-monthcheck>
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