<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>User Login</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body>
    @if (Session::get('fail'))
        {{ Session::get('fail') }}
    @endif

    <form action="{{ route('user.check') }}" method="POST">
        @csrf
        <input type="text" name="username" id="" placeholder="username" value="{{ old('username') }}">
        @error('username')
            {{ $message }}
        @enderror
        <input type="password" name="password" id="" placeholder="password" value="{{ old('password') }}">
        <input type="submit" value="Login">
    </form>
</body>
</html>