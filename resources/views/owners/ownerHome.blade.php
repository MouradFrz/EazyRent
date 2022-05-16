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
  <link rel="stylesheet" href="{{ asset('css/owner/index.css') }}">
@endsection

@section('content')

 @if (Auth::user()->agencyID)
     <p>This guy has an agency</p>

 @elseif ($hasRequest==1)  
 <div class="no-agency">
  <div class="container d-flex align-items-center justify-content-center">
    <div class="alert" role="alert" style="border:2px dashed rgb(130, 179, 139);background-color:rgb(130, 179, 139)">
      <p> Your request is being processed by our administrators. Please comeback later</p>
      <a href="{{ route('owner.logout') }}" onclick="event.preventDefault();document.getElementById('logout-form').submit();" class="btn btn-warning" style="float:right"> Logout</a>
 <form action="{{ route('owner.logout') }}" id="logout-form" method="post" style="display: none">@csrf</form>
    </div>
  </div>
</div>
 @else
  <div class="no-agency">
    <div class="container d-flex align-items-center justify-content-center">
      <div class="alert" role="alert">
        <p>
          It seem's that You don't have an agency yet! <br>
          Click the button below to add your agency now!
        </p>
        <br>
        <a class="btn btn-primary" href="{{ route('owner.createAgency') }}">
          Add agency Now!
        </a>
      </div>
    </div>
  </div>
 @endif

@endsection
