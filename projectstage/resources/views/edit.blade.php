<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="{{ asset( 'css/bootstrap.min.css' ) }}"> 
    <link rel="icon" href="{{ asset('imgs/logo.png') }}" type="image/x-icon"> 
    <script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
    <title>Modifier un donnée {{$page}}</title>
</head>
<body>
    @error('code')
        <p class="text-danger text-center fw-bold fs-5">Le code client doit etre unique!</p>
    @enderror

    @if($page == 'clients')
        <x-modform :activeData="$activeData" :page="$page" :users="$users"></x-modform>
    @else
        <x-modform :activeData="$activeData" :page="$page"></x-modform>
    @endif

</body>
</html>