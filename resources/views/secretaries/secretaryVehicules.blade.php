@extends('layouts.workerLayout')
@section('headTags')
{{--
<link rel="stylesheet" href="{{ asset('css/app.css') }}"> --}}
{{--
<link rel="stylesheet" href="{{ asset('css/owner/index.css') }}"> --}}
<link rel="stylesheet" href="{{asset('css/secretary/index.css')}}">
@endsection
@section('content')
<script>
  let vehicles = document.querySelector('#vehicles')
  vehicles.classList.add('active')
</script>
<div class="cars" style="min-height: 80vh">
  <div class="container">
    <h2 class="title">vehicles list</h2>
    <div class="row gx-3 gy-3">
      @if (count($vehicules) != 0)
      @foreach ($vehicules as $vehicule)
      <div class="col-12 col-md-6 col-lg-4">
        <div class="car">
          <div class="car_media">
            <a href="{{ route('secretary.vehiculeDetails', $vehicule->plateNb) }}">
              <img src="{{ asset('images/vehicules/imagePaths/' . $vehicule->imagePath) }}" alt="vehicules image">
            </a>
          </div>
          <div class="car_content">
            <div class="item">
              <strong>Vehicule:</strong>  {{ $vehicule->brand }} {{ $vehicule->model }}
            </div>
            <div class="item"><strong>Plate number:</strong> {{ $vehicule->plateNb }}</div>
            <div class="item"><strong>Garage ID:</strong> {{ $vehicule->garageID }}</div>
            @if (count($bookings) != 0)
            @foreach ($bookings as $booking)
            @if ($booking->vehiculePlateNB == $vehicule->plateNb)
            @if ($booking->state == 'REQUESTED' || $booking->state == 'ACCEPTED' || $booking->state == 'SIGNED' ||
            $booking->state == 'ON GOING')
            @if ($vehicule->availability)
            <button type="button" class="custom-btn custom-btn-dark my-3" disabled>Set
              unavailable</button>
            @else
            <button type="button" class="custom-btn custom-btn-success my-3" disabled>Set
              available</button>
            @endif
            @break

            @else
            @if ($vehicule->availability)
            <button type="button" class="custom-btn custom-btn-dark my-3"
              onclick="document.querySelector('#form{{ $vehicule->plateNb }}').submit()">Set
              unavailable</button>
            @else
            <button type="button" class="custom-btn custom-btn-success my-3"
              onclick="document.querySelector('#form{{ $vehicule->plateNb }}').submit()">Set
              available</button>
            @endif
            @break
            @endif
            @else
            @if ($loop->index == count($bookings) - 1)
            @if ($vehicule->availability)
            <button type="button" class="custom-btn custom-btn-dark my-3"
              onclick="document.querySelector('#form{{ $vehicule->plateNb }}').submit()">Set
              unavailable</button>
            @else
            <button type="button" class="custom-btn custom-btn-success my-3"
              onclick="document.querySelector('#form{{ $vehicule->plateNb }}').submit()">Set
              available</button>
            @endif
            @break

            @else
            @continue
            @endif
            @endif
            @endforeach
            @else
            @if ($vehicule->availability)
            <button type="button" class="custom-btn custom-btn-dark my-3"
              onclick="document.querySelector('#form{{ $vehicule->plateNb }}').submit()">Set
              unavailable</button>
            @else
            <button type="button" class="custom-btn custom-btn-success my-3"
              onclick="document.querySelector('#form{{ $vehicule->plateNb }}').submit()">Set
              available</button>
            @endif
            @endif
            <form action="{{ route('secretary.updateState', $vehicule->plateNb) }}" id="form{{ $vehicule->plateNb }}"
              method="POST">@csrf</form>
          </div>
        </div>
      </div>
      @endforeach
      <div class="col-12 col-md-6 col-lg-4">
        <div class="add-car">
          <div class="add-car_media">
            <i class="fa-solid fa-car"></i>
          </div>
          <a href="{{ route('secretary.addVehicule') }}" class="link link-underline">
            Add a new vehicle
          </a>
        </div>
      </div>
      @else
      <p>You have no vehicles</p>
      <div>
        <a href="{{ route('secretary.addVehicule') }}" style=" float: right;" class="custom-btn custom-btn-dark">Add
          a new vehicle</a>
        </button>
      </div>
      @endif
    </div>
  </div>
</div>
<div class="white-space"></div>
@endsection
@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
  integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
@endsection
