<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="{{ asset( 'css/bootstrap.min.css' ) }}">
    <title>Cnss</title>
</head>
<body class="p-2">
    @if(session('success'))
        <p class="alert alert-success">{{ session('success') }}</p>
    @endif
    <x-menu></x-menu>
    @php
        $empty = false;
    @endphp

    <x-tools page='cnss' :activeData="$cnssData" :users="$users"></x-tools>

    <table class="table table-hover text-center overflow-scroll" style="width :200%">
        <tr>
            @if(auth()->user()->role == 'Admin')
                <td colspan="3"></td>
            @else
                <td colspan="2"></td>
            @endif
            <td class="fw-bold fs-3">Janvier</td>
            <td class="fw-bold fs-3">Fevrier</td>
            <td class="fw-bold fs-3">Mars</td>
            <td class="fw-bold fs-3">Avril</td>
            <td class="fw-bold fs-3">Mai</td>
            <td class="fw-bold fs-3">Juin</td>
            <td class="fw-bold fs-3">Julliet</td>
            <td class="fw-bold fs-3">Aout</td>
            <td class="fw-bold fs-3">September</td>
            <td class="fw-bold fs-3">Octobre</td>
            <td class="fw-bold fs-3">Novembre</td>
            <td class="fw-bold fs-3">Decembre</td>
        </tr>
        <tr>
            <th>code client</th>
            <th>entreprise</th>
            @if(auth()->user()->role == 'Admin')
                <th>collaborateur</th>
            @endif
            @for($i = 0 ; $i < 12 ; $i++)
                <th>date de depot</th>
            @endfor
            
        </tr>
        @forelse ($cnssData as $cnss)
        <tr>
            <td>{{$cnss->clients->code}}</td>
            <td>{{$cnss->clients->nom}}</td>
            @if(auth()->user()->role == 'Admin')
                <td>{{$cnss->clients->users->name}}</td>
            @endif
            <x-monthcheck :activeData="$cnss" page='cnss'></x-monthcheck>
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