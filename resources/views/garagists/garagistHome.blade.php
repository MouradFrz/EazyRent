
@extends('layouts.workerLayout')
 @section('content')

 {{ Auth::guard('garagist')->user() }}
 <p>this is the garagist's homepage</p>

 <a href="{{ route('garagist.logout') }}" onclick="event.preventDefault();document.getElementById('logout-form').submit();"> Logout</a>
 <form action="{{ route('garagist.logout') }}" id="logout-form" method="post">@csrf</form>

 @endsection