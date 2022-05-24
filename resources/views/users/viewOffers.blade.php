@extends('layouts.userLayout')
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
    @foreach ($vehicules as $vehicule)
    <div class="minimized-offer">
      <div class="row">
        <div class="minimized-offer_media col-12 col-md-3">
          {{-- there is probleme when saving cars images the pathshould containt name of the image not the full path --}}
          <img src="{{asset('images/vehicules/imagePaths/'.$vehicule->imagePath  )}}" alt="">
        </div>
        <div class="minimized-offer_content col-md-9">
          <div class="d-flex justify-content-between">
            <div>
              <h2>{{$vehicule -> brand}} {{$vehicule -> model}}</h2>
            </div>
            <div class="text-end">
              <strong>
                @php
                $diff = $dropOffDate->diff($pickUpDate);
                $days = $diff->days;
                $hours = $diff->h;
                $price = $vehicule -> pricePerHour * $hours + $vehicule -> pricePerDay * $days;
                echo $price , ' dzd';
                @endphp
              </strong>
              <p>vehicle price</p>
            </div>
          </div>
          <hr />
          <div class="d-flex justify-content-between align-items-center">
            <div class="rating">
              @for($c=1;$c<=5;$c++)
              @if($vehicule -> rating >= $c)
              <i class="fa-solid fa-star" style="color:darkorange"></i>
              @else
              <i class="fa-solid fa-star"></i>
              @endif
              @endfor

            </div>
            <span>{{$vehicule -> rating}}</span>
            <a href="{{ route('user.viewOfferDetails',$vehicule->plateNb) }}" class="custom-btn">view More</a>
          </div>
        </div>
      </div>
    </div>
    @endforeach
  </div>
</div>
@endsection
