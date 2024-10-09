<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="{{ asset( 'css/bootstrap.min.css' ) }}"> 
    <script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
    <title>Votre Collaborateurs</title>
</head>
<body  class="p-2">
    <x-menu></x-menu>

    <div class="d-flex justify-content-center ">
        <div class="w-75">
            @if (session('userDlt'))
                <p class="alert alert-success alert-dismissible fade show" role="alert">{{ session('userDlt') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </p>
            @endif
            <div class="d-flex justify-content-between align-items-center bg-white shadow rounded p-3 mt-3 mb-3" style="position: sticky;top:18%;z-index:1">
                <h3 class="m-0">
                    Votre Collaborateurs 
                    <span class="bg-info rounded p-3 pt-1 pb-1 fs-4">{{count($users)}}</span>
                </h3>
                <p class="m-0">Données de l'année {{Date('Y')}}</p>
            </div>
            <div class="d-flex">
                <div class="w-50">
                    @foreach ($users as $user)
                        <details class="m-4 mt-0 mb-0">
                            <summary class="bg-body-secondary mb-2 rounded p-2 d-flex justify-content-between align-items-center">
                                <span>
                                    {{$user->name}}
                                </span>
                                <span>
                                    <a 
                                        class="btn btn-danger" 
                                        style="font-size: 13px" 
                                        href="{{route('user.delete' , $user)}}" 
                                        onclick="confirm('Est-ce-que vous etes sure de supprimer ce collaborateur? Tous les données associer à ce collaborateur va etre supprimer!')"
                                    >
                                        Supprimer
                                    </a>
                                </span>
                            </summary>
                            <div style="height: 200px; overflow-y:scroll;">
                                @foreach ($clients as $client)
                                    <ul>
                                        @if ($user->id == $client->users_id)
                                            <li>
                                                <a href="{{route('users.show' , ['id' => $client->id])}}">
                                                    {{$client->nom}}  
                                                </a>
                                            </li>
                                        @endif
                                    </ul>
                                @endforeach
                            </div>
                        </details>
    
                    @endforeach
                </div>
        
                @if (request()->has('id'))
                    <div>
                        <ul style="position: sticky; top:30%">
                            <li style="list-style-type: none" class="mb-2 fw-bold">{{$selectedClient->nom}}</li>
                            {{-- <hr> --}}
                            <li>
                                <span style="vertical-align: middle; width:150px;display:inline-block">Cnss </span>
                                @if (count($Cnss) > 0)
                                    <span class="btn btn-success rounded p-2 pt-0 pb-0" style="font-size: 13px">Il ya des données</span>
                                @else
                                    <span class="btn btn-danger rounded p-2 pt-0 pb-0" style="font-size: 13px">Vide</span>
                                @endif
                            </li>
                            <li>
                                <span style="vertical-align: middle; width:150px;display:inline-block">Tvam </span>
                                @if (count($Tvam) > 0)
                                    <span class="btn btn-success rounded p-2 pt-0 pb-0" style="font-size: 13px">Il ya des données</span>
                                @else
                                    <span class="btn btn-danger rounded p-2 pt-0 pb-0" style="font-size: 13px">Vide</span>
                                @endif
                            </li>
                            <li>
                                <span style="vertical-align: middle; width:150px;display:inline-block">Ir </span>
                                @if (count($Ir) > 0)
                                    <span class="btn btn-success rounded p-2 pt-0 pb-0" style="font-size: 13px">Il ya des données</span>
                                @else
                                    <span class="btn btn-danger rounded p-2 pt-0 pb-0" style="font-size: 13px">Vide</span>
                                @endif
                            </li>
                            <li>
                                <span style="vertical-align: middle; width:150px;display:inline-block">Droit de timbre </span>
                                @if (count($Droittimber) > 0)
                                    <span class="btn btn-success rounded p-2 pt-0 pb-0" style="font-size: 13px">Il ya des données</span>
                                @else
                                    <span class="btn btn-danger rounded p-2 pt-0 pb-0" style="font-size: 13px">Vide</span>
                                @endif
                            </li>
    
                            <hr>
    
                            <li>
                                <span style="vertical-align: middle; width:150px;display:inline-block">Tvat </span>
                                @if (count($Tvat) > 0)
                                    <span class="btn btn-success rounded p-2 pt-0 pb-0" style="font-size: 13px">Il ya des données</span>
                                @else
                                    <span class="btn btn-danger rounded p-2 pt-0 pb-0" style="font-size: 13px">Vide</span>
                                @endif
                            </li>
                            <li>
                                <span style="vertical-align: middle; width:150px;display:inline-block">Acompte </span>
                                @if (count($Acompte) > 0)
                                    <span class="btn btn-success rounded p-2 pt-0 pb-0" style="font-size: 13px">Il ya des données</span>
                                @else
                                    <span class="btn btn-danger rounded p-2 pt-0 pb-0" style="font-size: 13px">Vide</span>
                                @endif
                            </li>
    
                            <hr>
    
                            <li>
                                <span style="vertical-align: middle; width:150px;display:inline-block">Etat </span>
                                @if (count($Etat) > 0)
                                    <span class="btn btn-success rounded p-2 pt-0 pb-0" style="font-size: 13px">Il ya des données</span>
                                @else
                                    <span class="btn btn-danger rounded p-2 pt-0 pb-0" style="font-size: 13px">Vide</span>
                                @endif
                            </li>
                            <li>
                                <span style="vertical-align: middle; width:150px;display:inline-block">Tp </span>
                                @if (count($Tp) > 0)
                                    <span class="btn btn-success rounded p-2 pt-0 pb-0" style="font-size: 13px">Il ya des données</span>
                                @else
                                    <span class="btn btn-danger rounded p-2 pt-0 pb-0" style="font-size: 13px">Vide</span>
                                @endif
                            </li>
                            <li>
                                <span style="vertical-align: middle; width:150px;display:inline-block">Cm </span>
                                @if (count($Cm) > 0)
                                    <span class="btn btn-success rounded p-2 pt-0 pb-0" style="font-size: 13px">Il ya des données</span>
                                @else
                                    <span class="btn btn-danger rounded p-2 pt-0 pb-0" style="font-size: 13px">Vide</span>
                                @endif
                            </li>
                            <li>
                                <span style="vertical-align: middle; width:150px;display:inline-block">Bilan </span>
                                @if (count($Bilan) > 0)
                                    <span class="btn btn-success rounded p-2 pt-0 pb-0" style="font-size: 13px">Il ya des données</span>
                                @else
                                    <span class="btn btn-danger rounded p-2 pt-0 pb-0" style="font-size: 13px">Vide</span>
                                @endif
                            </li>
                            <li>
                                <span style="vertical-align: middle; width:150px;display:inline-block">Pv </span>
                                @if (count($Pv) > 0)
                                    <span class="btn btn-success rounded p-2 pt-0 pb-0" style="font-size: 13px">Il ya des données</span>
                                @else
                                    <span class="btn btn-danger rounded p-2 pt-0 pb-0" style="font-size: 13px">Vide</span>
                                @endif
                            </li>
                            <li>
                                <span style="vertical-align: middle; width:150px;display:inline-block">Irprof </span>
                                @if (count($Irprof) > 0)
                                    <span class="btn btn-success rounded p-2 pt-0 pb-0" style="font-size: 13px">Il ya des données</span>
                                @else
                                    <span class="btn btn-danger rounded p-2 pt-0 pb-0" style="font-size: 13px">Vide</span>
                                @endif
                            </li>
                            
                        </ul>
                    </div>
                @endif
            </div>
        </div>
    </div>
</body>
</html>