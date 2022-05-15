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
  
        @if (Auth::user()->agencyID)
            <p>This guy has an agency</p>
        @elseif ($hasRequest==1)
        <p>You sent a request . Wait</p>
        @else
        <p>This guy DOesnt have an an agency yet! create an agency</p>
        <a href="{{ route('owner.createAgency') }}">Add agency</a>
        @endif
        <a href="{{ route('owner.logout') }}" onclick="event.preventDefault();document.getElementById('logout-form').submit();"> Logout</a>
        <form action="{{ route('owner.logout') }}" id="logout-form" method="post">@csrf</form>
</body>
</html>