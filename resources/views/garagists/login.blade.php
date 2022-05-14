<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    @if (Session::get('fail'))
        {{ Session::get('fail') }}
    @endif

    <form action="{{ route('garagist.check') }}" method="POST">
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