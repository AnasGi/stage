<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="{{ asset( 'css/bootstrap.min.css' ) }}">
    <title>Accueil</title>
    <style>
        details {
            margin-bottom: 10px;
        }
    </style>
</head>
<body class="p-2">

    @if(session('newUser'))
        <p class="alert fw-bold fs-5 alert-success">{{ session('newUser') }}</p>
    @endif

    <x-menu></x-menu>

    <div class="d-flex justify-content-center mt-3">
        <form action="{{route('main.index')}}" class="d-flex justify-content-center gap-2 align-items-center">
            <div>
                <input list="clients-list" name="code" id="code" value="{{request('code')}}" placeholder="Choisir un client">
                <datalist id="clients-list">
                    @foreach ($clients as $item)
                        <option value="{{$item->code}}">{{$item->nom}}</option>
                    @endforeach
                </datalist> 
            </div>
            <div>
                <input type="text" name="annee" placeholder="Année" value="{{request('annee')}}">
            </div>
            <button class="btn btn-dark">Importer les données</button>
        </form>
    </div>

    <hr/>

    @if ($clientToFind !== null)
        @if (auth()->user()->role == "Admin")
            <h3 class="mb-4 bg-body-secondary p-2 rounded w-50">Collaborateur: {{$userName}}</h3>
        @endif
        <details open>
            <summary class="fw-bold fs-4">Déclaration mensuelle</summary>
            <table class="table table-bordered table-hover text-center">
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

        <details open>
            <summary class="fw-bold fs-4">Déclaration trimistrielle</summary>
            <table class="table table-bordered table-hover text-center">
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

        <details open>
            <summary class="fw-bold fs-4">Déclaration Annuelle</summary>
            <table class="table table-bordered table-hover text-center">
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
    @endif

        
</body>
</html>

