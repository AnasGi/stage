<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="{{ asset( 'css/bootstrap.min.css' ) }}"> 
    <link rel="icon" href="{{ asset('imgs/logo.png') }}" type="image/x-icon"> 
    <script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('js/apexcharts.min.js') }}"></script>
    <title>Accueil</title>
    <style>
        details {
            margin-bottom: 10px;
        }
    </style>
</head>
<body class="p-2">

    <x-menu :users="$users"></x-menu>

    @if (auth()->user()->role == "Admin")
        <div class="mt-3 mb-1 d-flex gap-1 align-items-center">
            <img src="{{asset('imgs/alert.png')}}" alt="alerts" style="width: 20px">
            <h6 class="fw-bold m-0 p-0">Notifications </h6>
        </div>
        <div class="d-flex justify-content-between align-items-center p-1 bg-body-secondary rounded">
            <x-notification page='cnss' :activeData="$CnssAll"></x-notification>
            <hr style="border:2px solid black">
            <x-notification page='tvam' :activeData="$TvamAll"></x-notification>
            <hr style="border:2px solid black">
            <x-notification page='ir' :activeData="$IrAll"></x-notification>
            <hr style="border:2px solid black">
            <x-notification page='droittimbre' :activeData="$DroittimberAll"></x-notification>
            <hr style="border:2px solid black">
            <x-notification page='tvat' :activeData="$TvatAll"></x-notification>
            <hr style="border:2px solid black">
            <x-notification page='acompte' :activeData="$AcompteAll"></x-notification>
            <hr style="border:2px solid black">
            <x-notification page='etat' :activeData="$EtatAll"></x-notification>
            <hr style="border:2px solid black">
            <x-notification page='bilan' :activeData="$BilanAll"></x-notification>
            <hr style="border:2px solid black">
            <x-notification page='cm' :activeData="$CmAll"></x-notification>
            <hr style="border:2px solid black">
            <x-notification page='tp' :activeData="$TpAll"></x-notification>
            <hr style="border:2px solid black">
            <x-notification page='irprof' :activeData="$IrprofAll"></x-notification>
            <hr style="border:2px solid black">
            <x-notification page='pv' :activeData="$PvAll"></x-notification>
        </div>
        <div class="d-flex justify-content-end mt-3 align-items-center">
            <form action="{{route('main.index')}}">
                <div class="d-flex justify-content-center gap-2 align-items-center">
                    <select name="users_id" id="users_id" class="form-control" style="width: 200px">
                        <option value="">Choisir un collaborateur</option>
                        @foreach ($users as $user)
                            @if (request('users_id') == $user->id)
                                <option selected value="{{$user->id}}">{{$user->name}}</option>
                            @else
                                <option value="{{$user->id}}">{{$user->name}}</option>
                            @endif
                        @endforeach
                    </select>
                    <button class="btn btn-warning">Afficher les notifications</button>
                </div>
            </form>
        </div>
        
        <hr>
    @endif

    <div class="d-flex justify-content-between mt-3 align-items-center">
        <h2 class="fw-bold">Suivi Client</h2>
        <form action="{{route('main.index')}}">
            <div class="d-flex justify-content-center gap-2 align-items-center">
                <div>
                    <input list="clients-list" class="form-control" name="code" id="code" value="{{request('code')}}" placeholder="Choisir un client">
                    <datalist id="clients-list" >
                        @foreach ($clients as $item)
                            <option value="{{$item->code}}">{{$item->nom}}</option>
                        @endforeach
                    </datalist> 
                </div>
                <div>
                    <input type="text" name="annee" placeholder="Année" class="form-control" value="{{request('annee')}}">
                </div>
                <button class="btn btn-dark">Importer les données</button>
                <a href="{{route('main.index')}}" class="btn btn-danger">Initialiser filtrage</a>
            </div>
        </form>
    </div>

    <hr>

    @if ($clientToFind !== null)
        <div class="mt-4">
            <div class="fw-bold mb-2">
                <div class="m-3 bg-body-secondary p-2 rounded d-flex justify-content-center gap-5">
                        @if (auth()->user()->role == "Admin")
                            <span class="d-flex align-items-center gap-2">
                                <img src="{{asset('imgs/collab.png')}}" alt="collaborateur" width="30" class="d-flex align-items-center gap-2">
                                <span>
                                    {{$userName}}
                                </span>
                            </span>
                        @endif
                        <span class="d-flex align-items-center gap-2">
                            <img src="{{asset('imgs/client.png')}}" alt="collaborateur" width="30" class="d-flex align-items-center gap-2">
                            <span>
                                {{$clientNameToFind}}                            
                            </span>
                        </span>
                        <span class="d-flex align-items-center gap-2">
                            <img src="{{asset('imgs/date.png')}}" alt="collaborateur" width="30" >
                            <span>
                                {{request('annee') ?? Date('Y')}}
                            </span>
                        </span>
                </div>
            </div>
            <details class="bg-body-secondary p-2 rounded m-3">
                <summary class="fw-bold fs-5">Déclaration Mensuelle</summary>
                <table class="table table-bordered table-hover text-center border-dark">
                    <tr>
                        <th></th>
                        <th  colspan="2">Tva mensuelle</th>
                        <th>Cnss</th>
                        <th colspan="2">Ir</th>
                        <th colspan="2">Droit de timbre</th>
                    </tr>
                    <tr>
                        <th></th>
                        <th>Date de depot</th>
                        <th>numero de depot</th>
    
                        <th>Date de depot</th>
    
                        <th>Date de depot</th>
                        <th>numero de depot</th>
    
                        <th>Date de depot</th>
                        <th>numero de depot</th>
                    </tr>
                    @for ($i = 1; $i < 13; $i++)
                        <tr>
                           <th>Mois {{$i}}</th>
    
                           @if ($Tvam == null)
                                <td></td>
                                <td></td>
                            @else
                                <td>{{ $Tvam->{'date_depot_'.$i} }}</td>
                                <td>{{ $Tvam->{'num_depot_'.$i} }}</td>
                           @endif
                           
                           @if ($Cnss == null)
                                <td></td>
                            @else
                                <td>{{ $Cnss->{'date_depot_'.$i} }}</td>
                           @endif
    
                           @if ($Ir == null)
                                <td></td>
                                <td></td>
                            @else
                                <td>{{ $Ir->{'date_depot_'.$i} }}</td>
                                <td>{{ $Ir->{'num_depot_'.$i} }}</td>
                           @endif
    
                           @if ($Droittimber == null)
                                <td></td>
                                <td></td>
                            @else
                                <td>{{ $Droittimber->{'date_depot_'.$i} }}</td>
                                <td>{{ $Droittimber->{'num_depot_'.$i} }}</td>
                           @endif
    
                        </tr>
                    @endfor
                </table>
            </details>  
    
            <details class="bg-body-secondary p-2 rounded m-3">
                <summary class="fw-bold fs-5">Déclaration Trimistrielle</summary>
                <table class="table table-bordered table-hover text-center border-dark">
                    <tr>
                        <th></th>
                        <th colspan="2">Acompte</th>
                        <th colspan="2">Tva trimistrielle</th>
                    </tr>
                    <tr>
                        <th></th>
                        <th>Date de depot</th>
                        <th>numero de depot</th>
    
                        <th>Date de depot</th>
                        <th>numero de depot</th>
                    </tr>
                    @for ($i = 0; $i < 5; $i++)
                        <tr>
                            @if ($i==0)
                                <th>Regularisation</th>
                                @if ($Acompte == null)
                                    <td></td>
                                    <td></td>
                                @else
                                    <td>{{ $Acompte->{'date_depot_'.$i} }}</td>
                                    <td>{{ $Acompte->{'num_depot_'.$i} }}</td>
                                @endif
                                @php
                                    continue;
                                @endphp
                            @endif
    
                           <th>Trimestre {{$i}}</th>
    
                            @if ($Acompte == null)
                                    <td></td>
                                    <td></td>
                            @else
                                    <td>{{ $Acompte->{'date_depot_'.$i} }}</td>
                                    <td>{{ $Acompte->{'num_depot_'.$i} }}</td>
                            @endif
    
                            @if ($Tvat == null)
                                    <td></td>
                                    <td></td>
                            @else
                                    <td>{{ $Tvat->{'date_depot_'.$i} }}</td>
                                    <td>{{ $Tvat->{'num_depot_'.$i} }}</td>
                            @endif
                        
    
                        </tr>
                    @endfor
                </table>
            </details>  
    
            <details class="bg-body-secondary p-2 rounded m-3">
                <summary class="fw-bold fs-5">Déclaration Annuelle</summary>
                <table class="table table-bordered table-hover text-center border-dark">
                    <tr>
                        <th></th>
                        <th>Etat 9421</th>
                        <th>Bilan</th>
                        <th>Tp</th>
                        <th>Cm</th>
                        <th>Ir Prof Agricole</th>
                    </tr>
                    <tr>
                        <th>Date de depot</th>
    
                        @if ($Etat == null)
                            <td></td>
                        @else
                            <td>{{ $Etat->date_depot }}</td>
                        @endif
                        @if ($Bilan == null)
                            <td></td>
                        @else
                            <td>{{ $Bilan->date_depot }}</td>
                        @endif
                        @if ($Tp == null)
                            <td></td>
                        @else
                            <td>{{ $Tp->date_depot }}</td>
                        @endif
                        @if ($Cm == null)
                            <td></td>
                        @else
                            <td>{{ $Cm->date_depot }}</td>
                        @endif
                        @if ($Irprof == null)
                            <td></td>
                        @else
                            <td>{{ $Irprof->date_depot }}</td>
                        @endif
                    </tr>
                    <tr>
                        <th>Numero de depot</th>
    
                        @if ($Etat == null)
                                <td></td>
                        @else
                            <td>{{ $Etat->num_depot }}</td>
                        @endif
    
                        @if ($Bilan == null)
                                <td></td>
                        @else
                            <td>{{ $Bilan->num_depot }}</td>
                        @endif
    
                        @if ($Tp == null)
                            <td></td>
                        @else
                            <td>{{ $Tp->num_depot }}</td>
                        @endif
    
                        @if ($Cm == null)
                            <td></td>
                        @else
                            <td>{{ $Cm->num_depot }}</td>
                        @endif
    
                        @if ($Irprof == null)
                            <td></td>
                        @else
                            <td>{{ $Irprof->num_depot }}</td>
                        @endif
                    </tr>
                </table>
            </details>  
        </div>
    @endif

</body>
</html>

