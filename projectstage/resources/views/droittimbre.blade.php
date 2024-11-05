<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="{{ asset( 'css/bootstrap.min.css' ) }}"> 
    <link rel="icon" href="{{ asset('imgs/logo.png') }}" type="image/x-icon"> 
    <script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
    <title>droit de timber</title>
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
    <x-tools page='droittimbre' :activeData="$droittimberData" :users="$users"></x-tools>
    <x-addform page='droittimbre' :activeData="$droittimberData" :users="$users" :clients="$clients"></x-addform>
    <x-alert :activeData="$droittimberData" page='droittimbre'></x-alert>

    <div class="overflow-x-scroll">
        <table class="table table-bordered table-hover text-center border-dark" style="width :300%">
            <tr>
                @if(auth()->user()->role == 'Admin')
                    <td colspan="3"></td>
                @else
                    <td colspan="2"></td>
                @endif
                <td colspan="2" class="fw-bold fs-3 {{Date('n') == 1 ? 'bg-info' : ''}}">
                    
                    Janvier</td>
                <td colspan="2" class="fw-bold fs-3 {{Date('n') == 2 ? 'bg-info' : ''}}">
                    
                    Fevrier</td>
                <td colspan="2" class="fw-bold fs-3 {{Date('n') == 3 ? 'bg-info' : ''}}">
                    
                    Mars</td>
                <td colspan="2" class="fw-bold fs-3 {{Date('n') == 4 ? 'bg-info' : ''}}">
                    
                    Avril</td>
                <td colspan="2" class="fw-bold fs-3 {{Date('n') == 5 ? 'bg-info' : ''}}">
                    
                    Mai</td>
                <td colspan="2" class="fw-bold fs-3 {{Date('n') == 6 ? 'bg-info' : ''}}">
                    
                    Juin</td>
                <td colspan="2" class="fw-bold fs-3 {{Date('n') == 7 ? 'bg-info' : ''}}">
                    
                    Julliet</td>
                <td colspan="2" class="fw-bold fs-3 {{Date('n') == 8 ? 'bg-info' : ''}}">
                    
                    Aout</td>
                <td colspan="2" class="fw-bold fs-3 {{Date('n') == 9 ? 'bg-info' : ''}}">
                    
                    Septembre</td>
                <td colspan="2" class="fw-bold fs-3 {{Date('n') == 10 ? 'bg-info' : ''}}">
                    
                    Octobre</td>
                <td colspan="2" class="fw-bold fs-3 {{Date('n') == 11 ? 'bg-info' : ''}}">
                    
                    Nouvembre</td>
                <td colspan="2" class="fw-bold fs-3 {{Date('n') == 12 ? 'bg-info' : ''}}">
                    
                    Decembre</td>
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
            @forelse ($droittimberData as $droittimber)
            <tr>
                <td>{{$droittimber->clients->code}}</td>
                <td>{{$droittimber->clients->nom}}</td>
                @if(auth()->user()->role == 'Admin')
                    <td>{{$droittimber->clients->users->name}}</td>
                @endif
                <x-monthcheck :activeData="$droittimber" page="droittimbre"></x-monthcheck>
                <td><a href="{{route('droittimbre.destroy' , $droittimber)}}" class="btn btn-danger" onclick="return confirm('Vous-etre sure de supprimer cette donnée?')">supprimer</a></td>
                <td><a href="{{route('droittimbre.update' , $droittimber)}}" class="btn btn-primary">modifier</a></td>
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