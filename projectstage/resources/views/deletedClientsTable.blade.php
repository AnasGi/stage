<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="{{ asset( 'css/bootstrap.min.css' ) }}"> 
    <script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
    <title>Tableau des clients en décharge / liquidation</title>
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
        <a href="{{route('clients.deleted')}}" class="m-2 btn btn-danger">Retour</a>
        <button class="m-2 btn btn-dark" onclick="window.print()">Imprimer PDF</button>
    </div>
    <div>
        <h4 class="text-center pb-2">Liste des clients en décharge / liquidation</h4>
        <table class="table table-bordered border-dark text-center" style="font-size: 13px">
            <tr>
                <th>Code client</th>
                <th>Entreprise</th>
                <th>PP/PM</th>
                <th>Adresse</th>
                <th>Activité</th>
                <th>Date début d'activité</th>
                <th>collaborateur</th>
                <th>Décharge / Liquidation</th>
                <th>Date Décharge / Liquidation</th>
            </tr>
            <tr>
                @foreach($deletedClients as $clt)
                    <td>{{$clt->code}}</td>
                    <td>{{$clt->nom}}</td>
                    <td>{{$clt->status}}</td>
                    <td>{{$clt->adresse}}</td>
                    <td>{{$clt->activite}}</td>
                    <td>{{$clt->debut_activite}}</td>
                    <td>{{$clt->users->name}}</td>
                    <td>{{$clt->deletetype}}</td>
                    <td>{{$clt->deleted_at->format('d/m/Y')}}</td>
                @endforeach
            </tr>
        </table>
    </div>
    
    
</body>
</html>