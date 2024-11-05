<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="{{ asset( 'css/bootstrap.min.css' ) }}"> 
    <link rel="icon" href="{{ asset('imgs/logo.png') }}" type="image/x-icon"> 
    <script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
    <title>Historique</title>
    <style>
        .timePoint{
            width: 10px;
            height: 10px;
            outline: 2px solid gray;
            outline-offset: 3px;
            border-radius: 100%
        }
        .timeLine{
            position: absolute;
            left: 4px;
            bottom: 5px;
            width: 2px;
            height: 40px;
            background: gray;
            z-index: -10;
        }
        
    </style>
</head>
<body class="p-2">
    <x-menu :users="$users"></x-menu>
    <div class="d-flex justify-content-center ">
        @if (count($clientsInHistory)==0)
            <div class="d-block mt-4">
                <div class="d-flex justify-content-center">
                    <img src="{{ asset('imgs/motif.png') }}" style="width:60px; height:60px;" alt="motif">
                </div>
                <p class="fw-bold text-danger fs-4">Historique est vide!</p>
            </div>
        @else
            <div class="w-75">
                <div class="d-flex justify-content-between align-items-center bg-white shadow rounded p-3 mt-3 mb-3">
                    <h3 class="m-0">
                        L'historique des clients  
                        <span class="bg-info fs-6 fw-bold" style="border-radius: 100% ; padding:4px 10px ; vertical-align:super">{{count($clientsInHistory)}}</span>
                    </h3>
                    <form action="{{route('clients.history')}}" method="GET" class="d-flex gap-3 align-items-center">
                        <input list="clients-list" name="clients_id" id="clients_id" value="{{request('clients_id')}}" class="p-1" placeholder="Choisir un client">
                        <datalist id="clients-list">
                            @foreach ($clientsInHistory as $item)
                                <option value="{{$item->clients_id}}">{{$item->clients()->withTrashed()->value('nom')}}</option>
                            @endforeach
                        </datalist> 
                        <button class="btn btn-dark">Cherche</button>
                    </form>
                </div>
                <div class="d-flex">
                    <div class="w-75">
                        @foreach ($clientsInHistory as $htclt)
                            <details class="m-4 mt-0 mb-0 w-100">
                                    <summary class="bg-body-secondary mb-2 rounded p-2 d-flex gap-3 align-items-center">
                                        <span class="w-50">
                                            {{$htclt->clients->code}}         
                                            {{$htclt->clients->nom}}         
                                        </span>
                                        <span class="bg-success p-1 fw-bold rounded text-light" style="font-size: 13px">
                                            {{$htclt->clients->users->name}}
                                        </span>                       
                                    </summary>
                                    <ul>
                                        @foreach ($history as $ht)
                                            @if ($ht->clients_id == $htclt->clients_id)
                                                <li class="d-flex justify-content-between align-items-center mb-1">
                                                    <div class="d-flex justify-content-center gap-3 align-items-center" style="position:relative">
                                                        <span class="timePoint bg-secondary"></span>
                                                        <span class="timeLine"></span>
                                                        <span class="text-body-secondary">
                                                            {{$ht->users()->withTrashed()->value('name')}}
                                                        </span>
                                                    </div>
                                                    <span class="bg-body-secondary p-1 fw-bold rounded" style="font-size: 12px">{{$ht->updated_at}}</span>
                                                </li>
                                            @endif
                                        @endforeach
                                    </ul>
                            </details>
                        @endforeach
                    </div>
            
                </div>
            </div>
        @endif
    </div>
</body>
</html>