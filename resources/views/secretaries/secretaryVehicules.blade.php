{{-- <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>User Homepage</title>
</head>
<body>

</body>
</html> --}}


@extends('layouts.workerLayout')
 @section('content')
 {{ Auth::guard('secretary')->user() }}
 <p>these are secretary vehicules</p>

 <a href="{{ route('secretary.logout') }}" onclick="event.preventDefault();document.getElementById('logout-form').submit();"> Logout</a>
 <form action="{{ route('secretary.logout') }}" id="logout-form" method="post">@csrf</form>
 @endsection