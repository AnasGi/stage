<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="{{ asset( 'css/bootstrap.min.css' ) }}">
    <title>Creer un nouvel utilisateur</title>
</head>
<body>
    <form action="{{route('register')}}" method="POST">
        @csrf
        nom
        <input type="text" name="name" /><br>
        password
        <input type="password" name="password" /><br>
        role
        <select name="role" id="">
            <option value=""></option>
            <option value="responsable">responsable</option>
            <option value="Admin">Admin</option>
        </select><br>
        <input type="submit" value="Creer">
    </form>
</body>
</html>