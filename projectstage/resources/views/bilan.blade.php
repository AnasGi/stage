<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="{{ asset( 'css/bootstrap.min.css' ) }}"> 
    <script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
    <title>Bilan</title>
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
    <x-tools page='bilan' :activeData="$bilanData" :users="$users"></x-tools>
    <x-addform page='bilan' :activeData="$bilanData" :users="$users" :clients="$clients"></x-addform>
    <x-alert :activeData="$bilanData" page='bilan'></x-alert>

    <table class="table table-bordered table-hover text-center border-dark">
        <tr>
            <th>code client</th>
            <th style="width: 200px">entreprise</th>
            @if(auth()->user()->role == 'Admin')
                <th>collaborateur</th>
            @endif
            <th>PP/PM</th>
            <th>date de depot</th>
            <th>numero de depot</th>
            
        </tr>
        @forelse ($bilanData as $bilan)
        <tr>
            <td>{{$bilan->clients->code}}</td>
            <td>{{$bilan->clients->nom}}</td>
            @if(auth()->user()->role == 'Admin')
                <td>{{$bilan->clients->users->name}}</td>
            @endif
            <td>{{$bilan->clients->status}}</td>
            @php
                $year = Date('Y')+1;
                $month = 0;
                if ($bilan->clients->status == 'PM') {
                    $month = 3;    
                }
                elseif ($bilan->clients->status == 'PP' || str_starts_with($bilan->clients->status , 'SARL')){
                    $month = 4;
                }
                $an = $bilan->annee+1;
                $deadlineDate = (new DateTime("last day of {$year}-{$month}"))->modify('-6 days');
                $compDate = (new DateTime("last day of {$an}-{$month}"))->modify('-3 days')->format('Y-m-d');
                $curentDate = Datetime::createFromFormat('Y-m-d' , Date('Y-n-d'));
            @endphp
            @if($bilan->date_depot > $compDate)
                <td class="bg-danger custom-title">{{$bilan->date_depot}}
                    <div class="motif d-flex align-items-center gap-2">
                        @if ($bilan->motif)
                            <img src="{{ asset('imgs/motif.png') }}" style="width:20px; height:20px;" alt="motif">
                            {{ $bilan->motif }}
                        @else
                            Aucun motif
                        @endif
                    </div>
                </td>
            @elseif($bilan->date_depot == null && ($curentDate >= $deadlineDate))
                <td class="bg-warning"></td>
            @else
                @if ($bilan->date_depot == null)
                    <td class="bg-body-secondary custom-title">
                        <div class="motif d-flex align-items-center gap-2">
                            @if ($bilan->motif)
                                <img src="{{ asset('imgs/motif.png') }}" style="width:20px; height:20px;" alt="motif">
                                {{ $bilan->motif }}
                            @else
                                Aucun motif
                            @endif
                        </div>
                    </td>
                @else
                    <td>{{$bilan->date_depot}}</td>
                @endif
            @endif
            <td>{{$bilan->num_depot}}</td>
            <td style="vertical-align: middle"><a href="{{route('bilan.destroy' , $bilan)}}" class="btn btn-danger" onclick="return confirm('Vous-etre sure de supprimer cette donnée?')">supprimer</a></td>
            <td style="vertical-align: middle"><a href="{{route('bilan.update' , $bilan)}}" class="btn btn-primary">modifier</a></td>
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