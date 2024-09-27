<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="{{ asset( 'css/bootstrap.min.css' ) }}">
    <title>Accueil</title>
</head>
<body>
    @if(session('success'))
        <p class="alert alert-success">{{ session('success') }}</p>
    @endif
    <form action="{{ route('clients.import') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div>
            <label for="file">Upload CSV File:</label>
            <input type="file" name="file" id="file" accept=".csv">
        </div>
        <div>
            <button type="submit">Import Clients</button>
        </div>
    </form>

    
    <form action="{{route('acueil.index')}}">
        <label for="">Rechercher par code de client</label>
        <input list="clients-list" name="code" id="code" value="{{old('code')}}">
        <datalist id="clients-list">
            @foreach ($clients as $client)
                <option value="{{$client->code}}">{{$client->code . $client->nom}}</option>
            @endforeach
        </datalist>
        <button class="btn btn-primary">Cherche</button>
    </form>


    <table class="table table-hover text-center overflow-scroll" style="width :200%">
        <tr>
            <th style="width: 100px">code client</th>
            <th>entreprise</th>
            <th style="width: 100px">PM/PP</th>
            <th>adresse</th>
            <th>IF</th>
            <th>TP</th>
            <th>ICE</th>
            <th>CNSS</th>
            <th>RC</th>
            <th style="width: 200px">date debut d'activite</th>
            <th>activite</th>
            <th>collaborateur</th>
        </tr>
            @foreach ($clients as $client)
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
                <td>{{$client->collaborateur}}</td>
            </tr>
            @endforeach
    </table>
    
</body>
</html>