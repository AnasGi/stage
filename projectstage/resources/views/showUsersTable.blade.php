<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="{{ asset( 'css/bootstrap.min.css' ) }}"> 
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
        <h4 class="text-center">Liste des collaborateurs</h4>
        <div class="d-flex justify-content-between p-2 mt-3">
            <h5>Le dernier mise à jour: {{$lastUpdate}}</h5>
            <h5>Année: {{Date('Y')}}</h5>
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