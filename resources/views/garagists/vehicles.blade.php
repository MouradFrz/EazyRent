@extends('layouts.workerLayout')


@section('headTags')
<link rel="stylesheet" href="{{ asset('css/app.css') }}">
<link rel="stylesheet" href="{{ asset('css/owner/index.css') }}">
@endsection


@section('content')
<script>
  let vehicles = document.querySelector('#vehicles')
  vehicles.classList.add('active')
</script>
<div>
  <div class="container">
    <h2 class="my-3">Vehicle management</h2>
    <hr>
    <div class="cards">
      @foreach ($vehicles as $vehicle)
      <div class="card-custom">
        <ul class="p-0">
          <img src="{{asset('images/vehicules/imagePaths/'.$vehicle->imagePath  )}}" alt=""
            style="max-height:200px; float:center;">
          <li class="mt-3">Vehicle: <span class="value">{{$vehicle->brand}} {{ $vehicle->model }}</span></li>
          <li>Plate number: <span class="value">{{ $vehicle->plateNb }}</span></li>
          <li><a href="{{ route('garagist.manageVehicle', $vehicle->plateNb) }}">Manage</a></span></li>
        </ul>
      </div>
      @endforeach
    </div>
  </div>
</div>
@endsection


@section('scripts')

@endsection
