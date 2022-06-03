@extends('layouts.workerLayout')
 @section('content')
 {{ Auth::guard('secretary')->user() }}
 <p>this is the Secretart homepage</p>

 <a href="{{ route('secretary.logout') }}" onclick="event.preventDefault();document.getElementById('logout-form').submit();"> Logout</a>
 <form action="{{ route('secretary.logout') }}" id="logout-form" method="post">@csrf</form>
 @endsection
