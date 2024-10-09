<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="{{ asset( 'css/bootstrap.min.css' ) }}">
    <title>Cnss</title>
</head>
<body class="p-2">
    @if(session('success'))
        <p class="alert fw-bold fs-5 alert-success">{{ session('success') }}</p>
    @endif
    <x-menu></x-menu>
    @php
        $empty = false;
    @endphp

    <x-tools page='cnss' :activeData="$cnssData" :users="$users"></x-tools>
    <x-addform page='cnss' :activeData="$cnssData" :users="$users" :clients="$clients"></x-addform>

    <x-alert :activeData="$cnssData" page='cnss'></x-alert>

    <table class="table table-bordered table-hover text-center overflow-scroll" style="width :200%">
        <tr>
            @if(auth()->user()->role == 'Admin')
                <td colspan="3"></td>
            @else
                <td colspan="2"></td>
            @endif
            <td class="fw-bold fs-3">
                @php
                    if(Date('n') == 1){
                        echo "<span class=' bg-info rounded p-1 pt-0 pb-0 '</span>";
                    } 
                @endphp
                Janvier</td>
            <td class="fw-bold fs-3">
                @php
                    if(Date('n') == 2){
                        echo "<span class=' bg-info rounded p-1 pt-0 pb-0 '</span>";
                    } 
                @endphp
                Fevrier</td>
            <td class="fw-bold fs-3">
                @php
                    if(Date('n') == 3){
                        echo "<span class=' bg-info rounded p-1 pt-0 pb-0 '</span>";
                    } 
                @endphp
                Mars</td>
            <td class="fw-bold fs-3">
                @php
                    if(Date('n') == 4){
                        echo "<span class=' bg-info rounded p-1 pt-0 pb-0 '</span>";
                    } 
                @endphp
                Avril</td>
            <td class="fw-bold fs-3">
                @php
                    if(Date('n') == 5){
                        echo "<span class=' bg-info rounded p-1 pt-0 pb-0 '</span>";
                    } 
                @endphp
                Mai</td>
            <td class="fw-bold fs-3">
                @php
                    if(Date('n') == 6){
                        echo "<span class=' bg-info rounded p-1 pt-0 pb-0 '</span>";
                    } 
                @endphp
                Juin</td>
            <td class="fw-bold fs-3">
                @php
                    if(Date('n') == 7){
                        echo "<span class=' bg-info rounded p-1 pt-0 pb-0 '</span>";
                    } 
                @endphp
                Julliet</td>
            <td class="fw-bold fs-3">
                @php
                    if(Date('n') == 8){
                        echo "<span class=' bg-info rounded p-1 pt-0 pb-0 '</span>";
                    } 
                @endphp
                Aout</td>
            <td class="fw-bold fs-3">
                @php
                    if(Date('n') == 9){
                        echo "<span class=' bg-info rounded p-1 pt-0 pb-0 '</span>";
                    } 
                @endphp
                September</td>
            <td class="fw-bold fs-3">
                @php
                    if(Date('n') == 10){
                        echo "<span class=' bg-info rounded p-1 pt-0 pb-0 '</span>";
                    } 
                @endphp
                Octobre</td>
            <td class="fw-bold fs-3">
                @php
                    if(Date('n') == 11){
                        echo "<span class=' bg-info rounded p-1 pt-0 pb-0 '</span>";
                    } 
                @endphp
                Novembre</td>
            <td class="fw-bold fs-3">
                @php
                    if(Date('n') == 12){
                        echo "<span class=' bg-info rounded p-1 pt-0 pb-0 '</span>";
                    } 
                @endphp
                Decembre</td>
        </tr>
        <tr>
            <th>code client</th>
            <th>entreprise</th>
            @if(auth()->user()->role == 'Admin')
                <th>collaborateur</th>
            @endif
            @for($i = 0 ; $i < 12 ; $i++)
                <th>date de depot</th>
            @endfor
            
        </tr>
        @forelse ($cnssData as $cnss)
        <tr>
            <td>{{$cnss->clients->code}}</td>
            <td>{{$cnss->clients->nom}}</td>
            @if(auth()->user()->role == 'Admin')
                <td>{{$cnss->clients->users->name}}</td>
            @endif
            <x-monthcheck :activeData="$cnss" page='cnss'></x-monthcheck>
            <td><a href="{{route('cnss.destroy' , $cnss)}}" class="btn btn-danger" onclick="confirm('Vous-etre sure de supprimer cette donnée?')">supprimer</a></td>
            <td><a href="{{route('cnss.update' , $cnss)}}" class="btn btn-primary">modifier</a></td>
        </tr>
        @empty
            @php
                $empty = true;
            @endphp
        @endforelse
    </table>
    @if ($empty)
        <p class="text-center fw-bold fs-4 mt-5 text-danger">Aucune resultat !</p>
    @endif
</body>
</html>