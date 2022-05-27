@extends('layouts.userLayout')
@section('head')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g==" crossorigin="anonymous" referrerpolicy="no-referrer" />
@endsection
@section('content')
<div class="view-offers">
  <div class="view-offers_hero">
    <div class="container d-flex flex-column align-items-center">
      <div class="view-offers_hero_content">
        <h1>view offers</h1>
        <h2>choose the most appropriate car for you!</h2>
      </div>
    </div>
  </div>
  {{-- <div class="view-offers_steps">
    <div class="container">
      <div class="view-offers_steps_steps d-felx justify-content-center align-items center">
        <div class="step">1</div>
        <div class="step">2</div>
        <div class="step">3</div>
      </div>
    </div>
  </div> --}}
  {{-- <div class="view-offers_content">
    <div class="offer">
      <img src="" alt="">
    </div>
  </div> --}}
  <div class="container">
    @foreach (session('vehicules') as $vehicule)
    <div class="minimized-offer row">
      <div class="minimized-offer_media col-12 col-md-3">
        {{-- there is probleme when saving cars images the pathshould containt name of the image not the full path --}}
        <img src="{{asset('images/vehicules/imagePaths/'.$vehicule->imagePath)}}" alt="">
      </div>
      <div class="minimized-offer_content col-md-9">
        <div class="head d-flex justify-content-between">
          <div>
            <h2>{{$vehicule -> brand}} {{$vehicule -> model}}</h2>
          </div>
          <div class="text-end">
            <strong>
              @php
              $diff = session('dropOffDate')->diff(session('pickUpDate'));
              $days = $diff->days;
              $hours = $diff->h;
              $price = $vehicule -> pricePerHour * $hours + $vehicule -> pricePerDay * $days;
              echo $price , ' dzd';
              @endphp
            </strong>
            <p>{{$vehicule -> pricePerDay}} dzd per day</p>
          </div>
        </div>
        <div class="prop">
          <ul class="list-group list-group-horizontal d-flex align-items-center justify-content-between">
            <li class="list-item "><i class="fa-solid fa-gas-pump"></i> fuel : {{$vehicule->fuel}} </li>
            <li class="list-item "><i class="fa-solid fa-gear"></i> gear type : {{$vehicule->gearType}} </li>
            <li class="list-item "><i class="fa-solid fa-door-closed"> </i> doors number : {{$vehicule->doorsNb}} </li>
            <li class="list-item "><i class="fa-solid fa-horse-head"></i> </i> horse power : {{$vehicule->horsePower}} </li>
            <li class="list-item "><i class="fa-solid fa-fan"></i></i> </i> air cooling :
              @if($vehicule->airCooling) true @else false @endif
            </li>
          </ul>
        </div>
        <hr />
        <div class="d-flex justify-content-between">
          <div class="rating">
            @for($c=1;$c<=5;$c++) @if($vehicule -> rating >= $c)
              <i class="fa-solid fa-star" style="color:darkorange;font-size:1rem;"></i>
              @else
              <i class="fa-solid fa-star" style="font-size:1rem;"></i>
              @endif
              @endfor
              <span>{{$vehicule -> rating}}</span>
          </div>
          <a
            href="{{ route('user.viewOfferDetails', ['plateNb'=>$vehicule->plateNb]) }}"
            class="custom-btn">view More
          </a>
        </div>
      </div>
    </div>
    @endforeach
  </div>
</div>
@endsection
