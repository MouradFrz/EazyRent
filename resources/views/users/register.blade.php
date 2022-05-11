<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Signup</title>
</head>
<body>

    @if (Session::get('success'))
        {{ Session::get('success') }}
    @endif
    @if (Session::get('fail'))
        {{ Session::get('fail') }}
    @endif
    
    {{ Auth::user() }}

    <form action="{{ route('user.create') }}" method="POST">
        @csrf
        <input type="text" name="firstName" id="" placeholder="firstName">
        <input type="text" name="lastName" id="" placeholder="lastName">
        <input type="text" name="address" id="" placeholder="address">
        <input type="date" name="birthDate" id="" placeholder="birthDate">
        <input type="text" name="username" id="" placeholder="username">
        <input type="text" name="email" id="" placeholder="email">
        <input type="text" name="password" id="" placeholder="password">
        <input type="text" name="idCard" id="" placeholder="idCard">
        <input type="submit" value="SignUp">
    </form>
</body>
</html>