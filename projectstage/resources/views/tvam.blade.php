<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="{{ asset( 'css/bootstrap.min.css' ) }}">
    <title>tvam</title>
</head>
<body class="p-2">
    @if(session('success'))
        <p class="alert alert-success">{{ session('success') }}</p>
    @endif
    <x-menu></x-menu>
    <form action="{{ route('tvam.import') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div>
            <label for="file">Upload CSV File:</label>
            <input type="file" name="file" id="file" accept=".csv">
        </div>
        <div>
            <button type="submit">Import tvam data</button>
        </div>
    </form>

    <form action="{{route('tvam.index')}}">
        <label for="">Rechercher par code de client</label>
        <input list="clients-list" name="code" id="code" value="{{old('code')}}">
        <datalist id="clients-list">
            @foreach ($tvamData as $tvam)
                <option value="{{$tvam->clients->code}}">{{$tvam->clients->nom}}</option>
            @endforeach
        </datalist>
        <button class="btn btn-primary">Cherche</button>
    </form>

    <table class="table table-hover text-center overflow-scroll" style="width :250%">
        <tr>
            <td colspan="3"></td>
            <td colspan="2" class="fw-bold fs-3">Janvier</td>
            <td colspan="2" class="fw-bold fs-3">Fevrier</td>
            <td colspan="2" class="fw-bold fs-3">Mars</td>
            <td colspan="2" class="fw-bold fs-3">Avril</td>
            <td colspan="2" class="fw-bold fs-3">Mai</td>
            <td colspan="2" class="fw-bold fs-3">Juin</td>
            <td colspan="2" class="fw-bold fs-3">Julliet</td>
            <td colspan="2" class="fw-bold fs-3">Aout</td>
            <td colspan="2" class="fw-bold fs-3">September</td>
            <td colspan="2" class="fw-bold fs-3">Octobre</td>
            <td colspan="2" class="fw-bold fs-3">Novembre</td>
            <td colspan="2" class="fw-bold fs-3">Decembre</td>
        </tr>
        <tr>
            <th>code client</th>
            <th style="width: 200px">entreprise</th>
            <th>collaborateur</th>
            @for($i = 0 ; $i < 12 ; $i++)
                <th>date de depot</th>
                <th>numero de depot</th>
            @endfor
            
        </tr>
        @foreach ($tvamData as $tvam)
        <tr>
            <td>{{$tvam->clients->code}}</td>
            <td>{{$tvam->clients->nom}}</td>
            <td>{{$tvam->clients->collaborateur}}</td>
            <x-monthcheck :tvam="$tvam"></x-monthcheck>
        </tr>
        @endforeach
    </table>
</body>
</html>