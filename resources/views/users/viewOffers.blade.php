@extends('layouts.userLayout')
@section('content')
<div class="view-offers">
  <div class="view-offers_hero">
    <div class="container d-flex flex-column align-items-center">
      <div class="view-offers_hero_content">
        <h1>view offers</h1>
        <h4>choose the most appropriate car for you!</h4>
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
    <div class="minimized-offer">
      <div class="row">
        <div class="minimized-offer_media col-12 col-md-3"></div>
        <div class="minimized-offer_content col-md-9">
          <div class="d-flex justify-content-between">
            <div>
              <h2>car name</h2>
              <p>-agnecy name-</p>
            </div>
            <div class="text-end">
              <strong>00.00 dzd</strong>
              <p>vehicle price</p>
            </div>
          </div>
          <hr />
          <div class="d-flex justify-content-between align-items-center">
            <div class="rating">
              <i class="fa-solid fa-star" style="color:darkorange"></i>
              <i class="fa-solid fa-star" style="color: darkorange"></i>
              <i class="fa-solid fa-star" style="color: darkorange"></i>
              <i class="fa-solid fa-star"></i>
              <i class="fa-solid fa-star"></i>
              <span>3.2</span>
            </div>
            <a href="#" class="custom-btn">view More</a>
          </div>
        </div>
      </div>
    </div>
  </div>

</div>
@endsection
