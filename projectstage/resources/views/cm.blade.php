<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="{{ asset( 'css/bootstrap.min.css' ) }}">
    <title>COTISATION MINIMALE</title>
</head>
<body class="p-2">
    @if(session('success'))
        <p class="alert alert-success">{{ session('success') }}</p>
    @endif
    <x-menu></x-menu>
    <form action="{{ route('cm.import') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div>
            <label for="file">Upload CSV File:</label>
            <input type="file" name="file" id="file" accept=".csv">
        </div>
        <div>
            <button type="submit">Import cm data</button>
        </div>
    </form>

    <form action="{{route('cm.index')}}">
        <label for="">Rechercher par code de client</label>
        <input list="clients-list" name="code" id="code" value="{{old('code')}}">
        <datalist id="clients-list">
            @foreach ($cmData as $cm)
                <option value="{{$cm->clients->code}}">{{$cm->clients->nom}}</option>
            @endforeach
        </datalist>
        <button class="btn btn-primary">Cherche</button>
    </form>

    <table class="table table-hover text-center overflow-scroll">
        <tr>
            <th>code client</th>
            <th style="width: 200px">entreprise</th>
            <th>collaborateur</th>
            <th>date de depot</th>
            <th>numero de depot</th>
            <th>Montant</th>
            
        </tr>
        @foreach ($cmData as $cm)
        <tr>
            <td>{{$cm->clients->code}}</td>
            <td>{{$cm->clients->nom}}</td>
            <td>{{$cm->clients->collaborateur}}</td>
            <td>{{$cm->date_depot}}</td>
            <td>{{$cm->num_depot}}</td>
            <td>{{$cm->montant}}</td>
        </tr>
        @endforeach
    </table>
</body>
</html>