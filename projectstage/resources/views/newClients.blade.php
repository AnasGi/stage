<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="{{ asset( 'css/bootstrap.min.css' ) }}"> 
    <link rel="icon" href="{{ asset('imgs/logo.png') }}" type="image/x-icon"> 
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
    <div id="noPrint" class="d-flex gap-2 align-items-center justify-content-between m-2">
        <div>
            <a href="{{route('clients.index')}}" class="btn btn-danger">Retour</a>
            <button class="btn btn-dark" onclick="window.print()">Imprimer PDF</button>
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
    <div class="mt-3">
        <h4 class="text-center fw-bold mb-4">Liste des clients nouvellement créer</h4>

        <table class="table table-bordered border-dark text-center" style="font-size: 13px">
            <tr>
                <th>code client</th>
                <th>entreprise</th>
                <th>collaborateur</th>
                <th>Date de création</th>
                <th>Motif</th>
            </tr>
            @foreach ($clients as $client)
                <tr>
                    <td>{{$client->code}}</td>
                    <td>{{$client->nom}}</td>
                    <td>{{$client->users->name}}</td>
                    <td>{{$client->created_at->format('d/n/Y')}}</td>
                    <td>
                        @if ($client->newCltMotif)
                            {{$client->newCltMotif}}
                        @else
                            <form action="{{route('clients.newCltMotif' , $client->id)}}" method="POST">
                                @csrf
                                <input type="text" name="newCltMotif" required>
                                <button>Affecter</button>
                            </form>                       
                        @endif
                    </td>
                        
                </tr>
            @endforeach
        </table>
    </div>
    
    
</body>
</html>