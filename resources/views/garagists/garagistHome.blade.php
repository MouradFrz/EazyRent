<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>User Homepage</title>
</head>
<body>
    {{ Auth::guard('garagist')->user() }}
        <p>this is the garagist's homepage</p>

        <a href="{{ route('garagist.logout') }}" onclick="event.preventDefault();document.getElementById('logout-form').submit();"> Logout</a>
        <form action="{{ route('garagist.logout') }}" id="logout-form" method="post">@csrf</form>
</body>
</html>