<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>User Homepage</title>
</head>
<body>
    {{ Auth::guard('web')->user() }}
        <p>this is the users homepage</p>

        <a href="{{ route('user.logout') }}" onclick="event.preventDefault();document.getElementById('logout-form').submit();"> Logout</a>
        <form action="{{ route('user.logout') }}" id="logout-form" method="post">@csrf</form>
</body>
</html>