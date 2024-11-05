<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="{{ asset( 'css/bootstrap.min.css' ) }}"> 
    <link rel="icon" href="{{ asset('imgs/logo.png') }}" type="image/x-icon"> 
    <script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
    <title>Tableau de collaborateurs</title>
    <style>
        @media print {
            #noPrint{
                visibility: hidden
            }
        }
    </style>
</head>
<body>
    <div id="noPrint">
        @if (auth()->user()->role=="Admin")
            <a href="{{route('users.show')}}" class="m-2 btn btn-danger">Retour</a>
        @else
            <a href="{{route('clients.index')}}" class="m-2 btn btn-danger">Retour</a>
        @endif
        <button class="m-2 btn btn-dark" onclick="window.print()">Imprimer PDF</button>
    </div>
    <div>
        <div class="d-flex justify-content-between align-items-center p-2 mt-3">
            <img src="{{asset('imgs/logo.png')}}" alt="logo" width="150">
            <h3 class="text-center fw-bold">Liste des docciers clients (Comptabilité)</h3>
            <div>
                <p class="m-0">F01 / FTC / TC</p>
                <p class="m-0">Version: 01/SD</p>
                <p class="m-0">03/09/2019</p>
            </div>
        </div>
        <hr>
        <div class="d-flex justify-content-between align-items-center p-2 mt-3">
            <div>
                <p class="m-0 fw-bold" style="font-size: 13px">Le dernier mise à jour: {{$lastUpdate->format('d/n/Y')}}</p>
                <p class="m-0 fw-bold" style="font-size: 13px">Année: {{Date('Y')}}</p>
            </div>
            <div class="text-end">
                <p class="m-0 fw-bold" style="font-size: 13px">Nombre totale des clients : {{count($clients)}}</p>
                <p class="m-0 fw-bold" style="font-size: 13px">Nombre totale des collaborateurs : {{count($users)}}</p>
            </div>
        </div>
        <table class="table table-bordered border-dark text-center" style="font-size: 13px">
            <tr>
                @foreach ($users as $user)
                    <th>
                        {{$user->name}} 
                    </th>
                @endforeach
            </tr>
            <tr>
                @foreach ($users as $user)
                    <td>
                        <ul style="list-style-type: none; padding-left: 0;">
                            @foreach ($clients as $client)
                                @if ($user->id == $client->users_id)
                                    <li class="p-1 pt-2 pb-2" style="border-bottom: 1px solid">
                                        <span class="fw-bold border border-1 p-1 m-1">
                                            {{$client->code}}
                                        </span>
                                        <span>
                                            {{$client->nom}}
                                        </span>
                                    </li>
                                @endif
                            @endforeach
                        </ul>
                    </td>
                @endforeach
            </tr>
        </table>
    </div>
    
    
</body>
</html>