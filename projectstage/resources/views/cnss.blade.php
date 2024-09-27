<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="{{ asset( 'css/bootstrap.min.css' ) }}">
    <title>Cnss</title>
</head>
<body>
    @if(session('success'))
        <p class="alert alert-success">{{ session('success') }}</p>
    @endif
    <form action="{{ route('cnss.import') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div>
            <label for="file">Upload CSV File:</label>
            <input type="file" name="file" id="file" accept=".csv">
        </div>
        <div>
            <button type="submit">Import cnss data</button>
        </div>
    </form>

    <form action="{{route('cnss.index')}}">
        <label for="">Rechercher par code de client</label>
        <input list="clients-list" name="code" id="code" value="{{old('code')}}">
        <datalist id="clients-list">
            @foreach ($cnssData as $cnss)
                <option value="{{$cnss->clients->code}}">{{$cnss->clients->code . $cnss->clients->nom}}</option>
            @endforeach
        </datalist>
        <button class="btn btn-primary">Cherche</button>
    </form>

    <table class="table table-hover text-center overflow-scroll" style="width :200%">
        <tr>
            <td colspan="3"></td>
            <td class="fw-bold fs-3">Janvier</td>
            <td class="fw-bold fs-3">Fevrier</td>
            <td class="fw-bold fs-3">Mars</td>
            <td class="fw-bold fs-3">Avril</td>
            <td class="fw-bold fs-3">Mai</td>
            <td class="fw-bold fs-3">Juin</td>
            <td class="fw-bold fs-3">Julliet</td>
            <td class="fw-bold fs-3">Aout</td>
            <td class="fw-bold fs-3">September</td>
            <td class="fw-bold fs-3">Octobre</td>
            <td class="fw-bold fs-3">Novembre</td>
            <td class="fw-bold fs-3">Decembre</td>
        </tr>
        <tr>
            <th>code client</th>
            <th>entreprise</th>
            <th>collaborateur</th>
            <th>date de depot</th>
            <th>date de depot</th>
            <th>date de depot</th>
            <th>date de depot</th>
            <th>date de depot</th>
            <th>date de depot</th>
            <th>date de depot</th>
            <th>date de depot</th>
            <th>date de depot</th>
            <th>date de depot</th>
            <th>date de depot</th>
            <th>date de depot</th>
        </tr>
        @foreach ($cnssData as $cnss)
        <tr>
            <td>{{$cnss->clients->code}}</td>
            <td>{{$cnss->clients->nom}}</td>
            <td>{{$cnss->clients->collaborateur}}</td>
            <td>{{ $cnss->date_depot_1 }}</td>
            <td>{{ $cnss->date_depot_2 }}</td>
            <td>{{ $cnss->date_depot_3 }}</td>
            <td>{{ $cnss->date_depot_4 }}</td>
            <td>{{ $cnss->date_depot_5 }}</td>
            <td>{{ $cnss->date_depot_6 }}</td>
            <td>{{ $cnss->date_depot_7 }}</td>
            <td>{{ $cnss->date_depot_8 }}</td>
            <td>{{ $cnss->date_depot_9 }}</td>
            <td>{{ $cnss->date_depot_10 }}</td>
            <td>{{ $cnss->date_depot_11 }}</td>
            <td>{{ $cnss->date_depot_12 }}</td>
        </tr>
        @endforeach
    </table>

    {{-- @for($i = 1 ; $i <13 ; $i++)
        <details>
            <summary>Mois {{$i}}</summary>
            <table class="table">
                <tr>
                    <th>code client</th>
                    <th>entreprise</th>
                    <th>collaborateur</th>
                    <th>date de depot</th>
                </tr>
                    @foreach ($cnssData as $cnss)
                    <tr>
                        <td>{{$cnss->clients->code}}</td>
                        <td>{{$cnss->clients->nom}}</td>
                        <td>{{$cnss->clients->collaborateur}}</td>
                        <td>{{ $cnss->{'date_depot_' . $i} }}</td>
                    </tr>
                    @endforeach
            </table>
        </details>
    @endfor --}}

</body>
</html>