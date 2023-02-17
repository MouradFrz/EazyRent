@extends('layouts.workerLayout')
 @section('content')
 <script>
  let dashboard = document.querySelector('#dashboard')
  dashboard.classList.add('active')
</script>
 {{ Auth::guard('secretary')->user() }}
 <p>this is the Secretart homepage</p>

 <a href="{{ route('secretary.logout') }}" onclick="event.preventDefault();document.getElementById('logout-form').submit();"> Logout</a>
 <form action="{{ route('secretary.logout') }}" id="logout-form" method="post">@csrf</form>
 @endsection
