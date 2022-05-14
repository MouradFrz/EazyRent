<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>User Homepage</title>
</head>
<body>
    <img src="{{ asset('images/owners/idCardImages/'. Auth::user()->idCardPath) }}" id="user-icon" alt="">
    {{ Auth::guard('owner')->user() }}
        <p>this is the users homepage</p>

        <a href="{{ route('owner.logout') }}" onclick="event.preventDefault();document.getElementById('logout-form').submit();"> Logout</a>
        <form action="{{ route('owner.logout') }}" id="logout-form" method="post">@csrf</form>
</body>
</html>