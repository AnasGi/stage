<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta htirptof-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="{{ asset( 'css/bootstrap.min.css' ) }}">
    <title>irprof</title>
</head>
<body class="p-2">
    @if(session('success'))
        <p class="alert fw-bold fs-5 alert-success">{{ session('success') }}</p>
    @endif
    <x-menu></x-menu>
    @php
        $empty = false;
    @endphp
    <x-tools page='irprof' :activeData="$irprofData" :users="$users"></x-tools>
    <x-addform page='irprof' :activeData="$irprofData" :users="$users" :clients="$clients"></x-addform>
    <x-alert :activeData="$irprofData" page='irprof'></x-alert>


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
        @forelse ($irprofData as $irprof)
            <tr>
                <td>{{$irprof->clients->code}}</td>
                <td>{{$irprof->clients->nom}}</td>
                @if(auth()->user()->role == 'Admin')
                    <td>{{$irprof->clients->users->name}}</td>
                @endif
                <td>{{$irprof->date_depot}}</td>
                <td>{{$irprof->num_depot}}</td>
                <td><a href="{{route('irprof.destroy', $irprof)}}" class="btn btn-danger" onclick="confirm('Vous-etre sure de supprimer cette donnée?')">supprimer</a></td>
            <td><a href="{{route('irprof.update' , $irprof)}}" class="btn btn-primary">modifier</a></td>
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