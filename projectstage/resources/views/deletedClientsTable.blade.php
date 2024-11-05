<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="{{ asset( 'css/bootstrap.min.css' ) }}"> 
    <link rel="icon" href="{{ asset('imgs/logo.png') }}" type="image/x-icon"> 
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
    <div id="noPrint" class="d-flex justify-content-between align-items-center">
        <div class="m-2">
            <a href="{{route('clients.deleted')}}" class="btn btn-danger">Retour</a>
            <button class="btn btn-dark" onclick="window.print()">Imprimer PDF</button>
        </div>
        <form action="{{route('clients.deletedTable')}}" class="d-flex justify-content-center gap-2 fw-bold align-items-center m-2">
            Tous <input type="radio" name="typeDlt" value="all" {{request("typeDlt") == "all" || !request("typeDlt") ? 'checked' : ''}}>
            <hr style="width: 10px">
            Décharger <input type="radio" name="typeDlt" value="dech" {{request("typeDlt") == "dech" ? 'checked' : ''}}>
            <hr style="width: 10px">
            Liquider <input type="radio" name="typeDlt" value="liq" {{request("typeDlt") == 'liq' ? 'checked' : ''}}>
            <hr style="width: 10px">
            <button class="btn btn-primary">Filtrer</button>
        </form>
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
            @foreach($deletedClients as $clt)
                <tr>
                    <td>{{$clt->code}}</td>
                    <td>{{$clt->nom}}</td>
                    <td>{{$clt->status}}</td>
                    <td>{{$clt->adresse}}</td>
                    <td>{{$clt->activite}}</td>
                    <td>{{$clt->debut_activite}}</td>
                    <td>{{$clt->users->name}}</td>
                    <td>{{$clt->deletetype}}</td>
                    <td>{{$clt->deleted_at->format('d/m/Y')}}</td>
                </tr>
            @endforeach
        </table>
    </div>
    
    
</body>
</html>