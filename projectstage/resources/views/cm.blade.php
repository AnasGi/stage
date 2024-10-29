<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="{{ asset( 'css/bootstrap.min.css' ) }}"> 
    <script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
    <title>Cotisation minimale</title>
    <style>
        .custom-title {
            cursor: pointer;
            position: relative;
        }

        .motif {
            position: absolute ;
            background-color: #ffffff;
            color: #a21f1f;
            font-weight: bold;
            padding: 5px 10px;
            border-radius: 5px;
            opacity: 0;
            pointer-events: none;
            transition: opacity 0.2s ease;
            font-size: 12px;
            z-index: 1;
        }

        .custom-title:hover {
            background-color: #f47777 !important;
        }

        .custom-title:hover div {
            opacity: 1;
        }

        td {
            vertical-align: middle;
        }
    </style>
</head>
<body class="p-2">
    @if(session('success'))
        <p class="alert fw-bold fs-5 alert-success alert-dismissible fade show" role="alert">{{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </p>
    @endif
    <x-menu :users="$users"></x-menu>
    @php
        $empty = false;
    @endphp
    <x-tools page='cm' :activeData="$cmData" :users="$users"></x-tools>
    <x-addform page='cm' :activeData="$cmData" :users="$users" :clients="$clients"></x-addform>
    <x-alert :activeData="$cmData" page='cm'></x-alert>

    <table class="table table-bordered table-hover text-center border-dark">
        <tr>
            <th>code client</th>
            <th style="width: 200px">entreprise</th>
            @if(auth()->user()->role == 'Admin')
                <th>collaborateur</th>
            @endif
            <th>date de depot</th>
            <th>numero de depot</th>
            <th>Montant</th>
            
        </tr>
        @forelse ($cmData as $cm)
        <tr>
            <td>{{$cm->clients->code}}</td>
            <td>{{$cm->clients->nom}}</td>
            @if(auth()->user()->role == 'Admin')
                <td>{{$cm->clients->users->name}}</td>
            @endif
            @php
                $year = Date('Y')+1;
                $month = 1;
                $an = $cm->annee+1;
                $deadlineDate = (new DateTime("last day of {$year}-{$month}"))->modify('-6 days');
                $compDate = (new DateTime("last day of {$an}-{$month}"))->modify('-3 days')->format('Y-m-d');
                $curentDate = Datetime::createFromFormat('Y-m-d' , Date('Y-n-d'));
            @endphp
            @if($cm->date_depot > $compDate)
                <td class="bg-danger custom-title">{{$cm->date_depot}}
                    <div class="motif d-flex align-items-center gap-2">
                        @if ($cm->motif)
                            <img src="{{ asset('imgs/motif.png') }}" style="width:20px; height:20px;" alt="motif">
                            {{ $cm->motif }}
                        @else
                            Aucun motif
                        @endif
                    </div>
                </td>
            @elseif($cm->date_depot == null && ($curentDate >= $deadlineDate))
                <td class="bg-warning"></td>
            @else
                @if ($cm->date_depot == null)
                    <td class="bg-body-secondary custom-title">
                        <div class="motif d-flex align-items-center gap-2">
                            @if ($cm->motif)
                                <img src="{{ asset('imgs/motif.png') }}" style="width:20px; height:20px;" alt="motif">
                                {{ $cm->motif }}
                            @else
                                Aucun motif
                            @endif
                        </div>
                    </td>
                @else
                    <td>{{$cm->date_depot}}</td>
                @endif
            @endif
            <td>{{$cm->num_depot}}</td>
            <td>{{$cm->montant}}</td>
            <td style="vertical-align: middle"><a href="{{route('cm.destroy' , $cm)}}" class="btn btn-danger" onclick="return confirm('Vous-etre sure de supprimer cette donnée?')">supprimer</a></td>
            <td style="vertical-align: middle"><a href="{{route('cm.update' , $cm)}}" class="btn btn-primary">modifier</a></td>
        </tr>
        @empty
            @php
                $empty=true;
            @endphp
        @endforelse
    </table>
    @if ($empty)
        <div class="d-flex justify-content-center align-items-center gap-3  mt-4">
            <img src="{{ asset('imgs/motif.png') }}" style="width:60px; height:60px;" alt="motif">
            <p class="text-center fw-bold fs-4 m-0 text-danger">Pas de données {{request('annee') ?? Date('Y')}}</p>
        </div>
    @endif
</body>
</html>