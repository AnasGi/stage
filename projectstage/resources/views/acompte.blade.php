<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="{{ asset( 'css/bootstrap.min.css' ) }}">
    <title>acompte</title>
</head>
<body class="p-2">
    @if(session('success'))
        <p class="alert alert-success">{{ session('success') }}</p>
    @endif
    <x-menu></x-menu>
    <form action="{{ route('acompte.import') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div>
            <label for="file">Upload CSV File:</label>
            <input type="file" name="file" id="file" accept=".csv">
        </div>
        <div>
            <button type="submit">Import acompte data</button>
        </div>
    </form>

    <form action="{{route('acompte.index')}}">
        <label for="">Rechercher par code de client</label>
        <input list="clients-list" name="code" id="code" value="{{old('code')}}">
        <datalist id="clients-list">
            @foreach ($acompteData as $acompte)
                <option value="{{$acompte->clients->code}}">{{$acompte->clients->nom}}</option>
            @endforeach
        </datalist>
        <button class="btn btn-primary">Cherche</button>
    </form>

    <table class="table table-hover text-center overflow-scroll" style="width :150%">
        <tr>
            <td colspan="3"></td>
            <td colspan="2" class="fw-bold fs-3">Regularisation </td>
            <td colspan="2" class="fw-bold fs-3">1ere trimestre </td>
            <td colspan="2" class="fw-bold fs-3">2ere trimestre </td>
            <td colspan="2" class="fw-bold fs-3">3ere trimestre </td>
            <td colspan="2" class="fw-bold fs-3">4ere trimestre </td>
        </tr>
        <tr>
            <th>code client</th>
            <th style="width: 200px">entreprise</th>
            <th>collaborateur</th>
            @for($i = 0 ; $i < 5 ; $i++)
                <th>date de depot</th>
                <th>numero de depot</th>
            @endfor
            
        </tr>
        @foreach ($acompteData as $acompte)
        <tr>
            <td>{{$acompte->clients->code}}</td>
            <td>{{$acompte->clients->nom}}</td>
            <td>{{$acompte->clients->collaborateur}}</td>
            <x-monthcheck :acompte="$acompte"></x-monthcheck>
        </tr>
        @endforeach
    </table>
</body>
</html>