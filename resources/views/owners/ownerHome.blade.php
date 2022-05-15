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
</html>

 --}}


@extends('layouts.workerLayout')
@section('headTags')
<title>Owner - Homepage</title>
<link rel="stylesheet" href="{{ asset('css/app.css') }}">
@endsection



 @section('content')
  
 @if (Auth::user()->agencyID)
     <p>This guy has an agency</p>
     
 @elseif ($hasRequest==1)
 <div class="alert alert-success text-center " role="alert">
    Your request is being processed by our administrators. Please comeback later
  </div>
  <a href="{{ route('owner.logout') }}" onclick="event.preventDefault();document.getElementById('logout-form').submit();" class="btn btn-warning" style="float:right"> Logout</a>
 <form action="{{ route('owner.logout') }}" id="logout-form" method="post" style="display: none">@csrf</form>
 @else 
 <div class="d-flex flex-column">
 <div class="alert alert-dark text-center " role="alert">
    You don't have an agency yet! Click the button below to add your agency now!
  </div>
  <div class="d-flex justify-content-between w-100">
 <a class="btn btn-success" style="width: 120px" href="{{ route('owner.createAgency') }}">Add agency</a>
 
 <a href="{{ route('owner.logout') }}" onclick="event.preventDefault();document.getElementById('logout-form').submit();" class="btn btn-warning" style="float:right"> Logout</a>
 <form action="{{ route('owner.logout') }}" id="logout-form" method="post" style="display: none">@csrf</form>
  </div>
 </div>
 @endif
 
 @endsection