<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="{{ asset( 'css/bootstrap.min.css' ) }}"> 
    <script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
    <title>Acompte</title>
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

    <x-tools page='acompte' :activeData="$acompteData" :users="$users"></x-tools>
    <x-addform page='acompte' :activeData="$acompteData" :users="$users" :clients="$clients"></x-addform>
    <x-alert :activeData="$acompteData" page='acompte'></x-alert>


    <table class="table table-bordered table-hover text-center overflow-scroll" style="width :150%">
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
            <td><a href="{{route('acompte.destroy' , $acompte)}}" class="btn btn-danger" onclick="confirm('Vous-etre sure de supprimer cette donnée?')">supprimer</a></td>
            <td><a href="{{route('acompte.update' , $acompte)}}" class="btn btn-primary">modifier</a></td>
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