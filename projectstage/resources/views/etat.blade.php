<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="{{ asset( 'css/bootstrap.min.css' ) }}">
    <title>etat</title>
</head>
<body class="p-2">
    @if(session('success'))
        <p class="alert alert-success">{{ session('success') }}</p>
    @endif
    <x-menu></x-menu>
    <form action="{{ route('etat.import') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div>
            <label for="file">Upload CSV File:</label>
            <input type="file" name="file" id="file" accept=".csv">
        </div>
        <div>
            <button type="submit">Import etat data</button>
        </div>
    </form>

    <form action="{{route('etat.index')}}">
        <label for="">Rechercher par code de client</label>
        <input list="clients-list" name="code" id="code" value="{{old('code')}}">
        <datalist id="clients-list">
            @foreach ($etatData as $etat)
                <option value="{{$etat->clients->code}}">{{$etat->clients->nom}}</option>
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
            
        </tr>
        @foreach ($etatData as $etat)
        <tr>
            <td>{{$etat->clients->code}}</td>
            <td>{{$etat->clients->nom}}</td>
            <td>{{$etat->clients->collaborateur}}</td>
            <td>{{$etat->date_depot}}</td>
            <td>{{$etat->num_depot}}</td>
        </tr>
        @endforeach
    </table>
</body>
</html>