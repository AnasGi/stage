<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="{{ asset( 'css/bootstrap.min.css' ) }}"> 
    <link rel="icon" href="{{ asset('imgs/logo.png') }}" type="image/x-icon">
    <script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
    <title>Liste des clients</title>
    <style>
        td , th{
            vertical-align: middle;
            text-transform: capitalize
        }
    </style>
</head>
<body class="p-2">
    <x-menu :users="$users"></x-menu>
    @if(session('add'))
        <p class="alert w-50 fw-bold alert-success mt-3 alert-dismissible fade show" role="alert">{{ session('add') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </p>
    @endif    
    @if(session('success'))
        <p class="alert w-50 fw-bold mt-3 alert-success alert-dismissible fade show" role="alert">{{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </p>
    @endif
    @if(session('restored'))
        <p class="alert w-50 fw-bold mt-3 alert-success alert-dismissible fade show" role="alert">{{ session('restored') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </p>
    @endif
    @if(count($clients)<=0)
        <p class="alert w-50 alert-danger m-2 mt-3 fw-bold">Il faut inserer des clients pour assurer la bonne fonctionnement du logiciel!</p>
    @endif
    @php
        $empty = false;
    @endphp

    <x-tools page='clients' :activeData="$clients" :users="$users"></x-tools>

    @if (auth()->user()->role == "Admin")
        <x-addform page='clients' :activeData="$clients" :users="$users"></x-addform>
    @endif
    <p class="m-0 mt-4 fw-bold">Nombre des données: {{count($clients)}}</p>

    <div class="overflow-x-scroll">
        <table class="table table-bordered border-dark table-hover text-center" style="width: 200%">
            <tr>
                <th style="width: 100px">code client</th>
                <th>entreprise</th>
                <th>Forme juridique</th>
                <th>adresse</th>
                <th>IF</th>
                <th>TP</th>
                <th>ICE</th>
                <th>CNSS</th>
                <th>RC</th>
                <th style="width: 200px">date debut d'activite</th>
                <th>activite</th>
                <th>ville</th>
                @if(auth()->user()->role == 'Admin')
                    <th>collaborateur</th>
                @endif
            </tr>
                @forelse ($clients as $client)
                <tr>
                    <td>{{$client->code}}</td>
                    <td>{{$client->nom}}</td>
                    <td>{{$client->status}}</td>
                    <td>{{$client->adresse}}</td>
                    <td>{{$client->IF}}</td>
                    <td>{{$client->TP}}</td>
                    <td>{{$client->ICE}}</td>
                    <td>{{$client->CNSS}}</td>
                    <td>{{$client->RC}}</td>
                    <td>{{$client->debut_activite}}</td>
                    <td>{{$client->activite}}</td>
                    <td>{{$client->ville}}</td>
                    @if(auth()->user()->role == 'Admin')
                        <td>{{$client->users->name}}</td>
                        <td>
                            <div class="dropdown">
                                <button class="btn btn-danger dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                supprimer
                                </button>
                                <ul class="dropdown-menu">
    
                                    <li>
                                        <a 
                                        class="dropdown-item"
                                        href="{{route('clients.destroy' , ['client'=>$client , 'deletetype'=>'liquidation'])}}" 
                                        onclick="return confirm('Vous-etre sure de supprimer ce client, tous les données associées vont etre supprimer?')"
                                        >
                                        Liquidation
                                        </a>
                                    </li>
                                    <li><hr class="dropdown-divider"></li>
                                    <li>
                                        <a 
                                        class="dropdown-item"
                                        href="{{route('clients.destroy' , ['client'=>$client , 'deletetype'=>'decharge'])}}" 
                                        onclick="return confirm('Vous-etre sure de supprimer ce client, tous les données associées vont etre supprimer?')"
                                        >
                                        Décharge
                                        </a>
                                    </li>
                                
                                </ul>
                            </div>
                        </td>
                        <td><a href="{{route('clients.update' , $client)}}" class="btn btn-primary">modifier</a></td>
                    @endif
                </tr>
                @empty
                    @php
                        $empty = true;
                    @endphp
                @endforelse
        </table>
    </div>
    @if ($empty)
    <div class="d-flex justify-content-center align-items-center gap-3  mt-4">
        <img src="{{ asset('imgs/motif.png') }}" style="width:60px; height:60px;" alt="motif">
        <p class="text-center fw-bold fs-4 m-0 text-danger">Pas de données</p>
    </div>
    @endif
</body>
</html>