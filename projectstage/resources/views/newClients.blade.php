<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="{{ asset( 'css/bootstrap.min.css' ) }}"> 
    <script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
    <title>Clients nouvellement créer</title>
    <style>
        @media print {
            #noPrint{
                visibility: hidden
            }
        }
    </style>
</head>
<body>
    <div id="noPrint" class="d-flex gap-2 align-items-center justify-content-around">
        <div>
            <a href="{{route('clients.index')}}" class="m-2 btn btn-danger">Retour</a>
            <button class="m-2 btn btn-dark" onclick="window.print()">Imprimer PDF</button>
        </div>
        <div class="d-flex justify-content-center">
            <form action="{{route('clients.new')}}" class="d-flex gap-2 align-items-center">
                <input type="text" name="annee" id="" placeholder="Année" value="{{request('annee')}}">
                <input type="text" name="mois" id="" placeholder="Mois" value="{{request('mois')}}">
                <button class="btn btn-primary p-3 pt-1 pb-1">Filtrer</button>
                <a href="{{route('clients.new')}}" class="btn btn-danger p-3 pt-1 pb-1">Initialiser filtrage</a>
            </form>
        </div>
    </div>
    <div class="mt-2">
        <h4 class="text-center">Liste des clients nouvellement créer</h4>

        <table class="table table-bordered border-dark text-center" style="font-size: 13px">
            <tr>
                <th>code client</th>
                <th>entreprise</th>
                <th>PM/PP</th>
                <th>adresse</th>
                <th>date debut d'activite</th>
                <th>activite</th>
                <th>collaborateur</th>
            </tr>
            @foreach ($clients as $client)
                <tr>
                    <td>{{$client->code}}</td>
                    <td>{{$client->nom}}</td>
                    <td>{{$client->status}}</td>
                    <td>{{$client->adresse}}</td>
                    <td>{{$client->debut_activite}}</td>
                    <td>{{$client->activite}}</td>
                    <td>{{$client->activite}}</td>
                    <td>{{$client->users->name}}</td>
                </tr>
            @endforeach
        </table>
    </div>
    
    
</body>
</html>