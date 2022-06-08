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
  <div class="container">
    @if( count($vehicules) == 0)
      <p class="text-center">there is no available vehicles</p>
      <p class="text-center">change search values or try later</p>
    @else
    @foreach ($vehicules as $vehicule)
    <div class="minimized-offer row">
      <div class="minimized-offer_media col-12 col-md-3">
        <img src="{{asset('images/vehicules/imagePaths/'.$vehicule->imagePath)}}" alt="">
      </div>
      <div class="minimized-offer_content col-md-9">
        <div class="head d-flex justify-content-between">
          <div>
            <h2>{{$vehicule -> brand}} {{$vehicule -> model}}</h2>
          </div>
          <div class="price">
            <strong>
              @php
              $diff = session('dropOffDate')->diff(session('pickUpDate'));
              $days = $diff->days;
              $hours = $diff->h;
              $price = $vehicule -> pricePerHour * $hours + $vehicule -> pricePerDay * $days;
              echo $price , ' dzd';
              @endphp
            </strong>
            <p>{{$vehicule -> pricePerDay}} dzd /day</p>
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
            @for($c=1;$c<=5;$c++)
              @if($vehicule -> rating >= $c)
              <i class="fa-solid fa-star" style="color:darkorange;font-size:1rem;"></i>
              @else
              <i class="fa-solid fa-star" style="font-size:1rem;"></i>
              @endif
            @endfor
              <span>{{($vehicule -> rating == null) ? 0 : $vehicule -> rating }}</span>
          </div>
          <a
            href="{{ route('user.viewOfferDetails', ['plateNb'=>$vehicule->plateNb]) }}"
            class="custom-btn custom-btn-dark">view More
          </a>
        </div>
      </div>
    </div>
    @endforeach
    @endif
  </div>
</div>
@endsection
