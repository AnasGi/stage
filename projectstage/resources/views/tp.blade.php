<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="{{ asset( 'css/bootstrap.min.css' ) }}"> 
    <script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
    <title>Taxes profissionelles</title>
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
    <x-tools page='tp' :activeData="$tpData" :users="$users"></x-tools>
    <x-addform page='tp' :activeData="$tpData" :users="$users" :clients="$clients"></x-addform>
    <x-alert :activeData="$tpData" page='tp'></x-alert>


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
        @forelse ($tpData as $tp)
        <tr>
            <td>{{$tp->clients->code}}</td>
            <td>{{$tp->clients->nom}}</td>
            @if(auth()->user()->role == 'Admin')
                <td>{{$tp->clients->users->name}}</td>
            @endif
            <td>{{$tp->date_depot}}</td>
            <td>{{$tp->num_depot}}</td>
            <td><a href="{{route('tp.destroy' , $tp)}}" class="btn btn-danger" onclick="confirm('Vous-etre sure de supprimer cette donnée?')">supprimer</a></td>
            <td><a href="{{route('tp.update' , $tp)}}" class="btn btn-primary">modifier</a></td>
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