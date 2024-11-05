<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta httvat-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="{{ asset( 'css/bootstrap.min.css' ) }}"> 
    <link rel="icon" href="{{ asset('imgs/logo.png') }}" type="image/x-icon"> 
    <script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
    <title>Tva trimistrielle</title>
</head>
<body class="p-2">
<x-menu :users="$users"></x-menu>
    @if(session('add'))
        <p class="alert w-50 fw-bold alert-success mt-3 alert-dismissible fade show" role="alert">{{ session('add') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </p>
    @endif        @if(session('success'))
        <p class="alert w-50 fw-bold alert-success alert-dismissible fade show" role="alert">{{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </p>
    @endif
    @php
        $empty = false;
    @endphp
    <x-tools page='tvat' :activeData="$tvatData" :users="$users"></x-tools>
    <x-addform page='tvat' :activeData="$tvatData" :users="$users" :clients="$clients"></x-addform>
    <x-alert :activeData="$tvatData" page='tvat'></x-alert>

    <div class="overflow-x-scroll">
        <table class="table table-bordered table-hover text-center border-dark" style="width :150%">
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
                <td><a href="{{route('tvat.destroy' , $tvat)}}" class="btn btn-danger" onclick="return confirm('Vous-etre sure de supprimer cette donnée?')">supprimer</a></td>
                <td><a href="{{route('tvat.update' , $tvat)}}" class="btn btn-primary">modifier</a></td>
            </tr>
            @empty
                @php
                    $empty=true;
                @endphp
            @endforelse
        </table>
    </div>
    @if ($empty)
        <div class="d-flex justify-content-center align-items-center gap-3  mt-4">
            <img src="{{ asset('imgs/motif.png') }}" style="width:60px; height:60px;" alt="motif">
            <p class="text-center fw-bold fs-4 m-0 text-danger">Pas de données {{request('annee') ?? Date('Y')}}</p>
        </div>
    @endif
</body>
</html>