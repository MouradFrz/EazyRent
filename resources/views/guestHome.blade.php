@extends('layouts.userLayout')

@section('content')
<div>
    <div
      class="container d-flex align-items-center justify-content-center flex-column"
    >
      <div
        class="search-panel d-flex align-itmes-center justify-content-center flex-column"
      >
        <div class="location d-flex flex-column">
          <label for="">Pick-up location :</label>
          <input class="inputs" type="text" />
          <div class="location d-flex flex-column" v-if="!pickUpSameAsDropOff">
            <label class="dropOffInput" for="">Drop off location :</label>
            <input class="inputs dropOffInput" type="text" />
          </div>
          <div class="d-flex align-items-center">
            <input
              type="checkbox"
              class="dropOffCheck"
              name=""
              id=""
              checked
            />
            <p>Drop off at same location</p>
          </div>
        </div>
        <div class="date-time d-flex justify-content-between">
          <div class="left d-flex flex-column">
            <label for="">Pick-up date :</label>
            <input class="inputs" type="date" />
            <input class="inputs" type="time" />
            <div class="d-flex align-items-center">
              <input
                type="checkbox"
                class="driverAgeCheck"
                name=""
                id=""
              />
              <p>Driver age is less than 25</p>
            </div>
            <div class="d-flex align-items-center driverAge" >
              <p>Driver's age :</p>
              <input
                type="number"
                class="inputs "
                style="margin-left: 16px"
                min="18"
                max="25"
              />
            </div>
          </div>
          <div class="right d-flex flex-column justify-content-between">
            <div class="d-flex flex-column m-0">
              <label for="">Drop off date :</label>
              <input class="inputs" type="date" />
              <input class="inputs" type="time" />
              <div class="d-flex align-items-center">
                <input type="checkbox" name="" id="" checked />
                <p>Driver's licence older than 2 years</p>
              </div>
            </div>
            <button class="custom-btn">Search</button>
          </div>
        </div>
      </div>
      <div
        class="why-us d-flex align-items-center justify-content-center flex-column"
        style="margin-bottom: 60px"
      >
        <h1 style="margin-bottom: 40px">Why us ?</h1>
        <div
          class="cards-container d-flex align-items-center flex-wrap justify-content-center mb-5"
        >
        <div
        class="card d-flex flex-column"
      >
        <i class="bi bi-square-fill"></i>
        <h1>Lorem ipsum</h1>
        <p>
          Lorem ipsum dolor sit amet consectetur, adipisicing elit. Assumenda
          facilis magni blanditiis enim tempora quis.
        </p>
      </div> 
      <div
      class="card d-flex flex-column"
    >
      <i class="bi bi-square-fill"></i>
      <h1>Lorem ipsum</h1>
      <p>
        Lorem ipsum dolor sit amet consectetur, adipisicing elit. Assumenda
        facilis magni blanditiis enim tempora quis.
      </p>
    </div>
    <div
    class="card d-flex flex-column"
  >
    <i class="bi bi-square-fill"></i>
    <h1>Lorem ipsum</h1>
    <p>
      Lorem ipsum dolor sit amet consectetur, adipisicing elit. Assumenda
      facilis magni blanditiis enim tempora quis.
    </p>
  </div>
        </div>
        <div
          id="carouselExampleIndicators"
          class="carousel slide w-100"
          data-bs-ride="carousel"
        >
          <div class="carousel-indicators">
            <button
              type="button"
              data-bs-target="#carouselExampleIndicators"
              data-bs-slide-to="0"
              class="active"
              aria-current="true"
              aria-label="Slide 1"
            ></button>
            <button
              type="button"
              data-bs-target="#carouselExampleIndicators"
              data-bs-slide-to="1"
              aria-label="Slide 2"
            ></button>
            <button
              type="button"
              data-bs-target="#carouselExampleIndicators"
              data-bs-slide-to="2"
              aria-label="Slide 3"
            ></button>
          </div>
          <div class="carousel-inner">
            <div class="carousel-item active">
              <div class="wrapper d-flex justify-content-center align-items-center flex-column">
                <i class="bi bi-square-fill"></i>
                <h1>Lorem ipsum</h1>
                <p>Lorem ipsum dolor sit amet , adipisicing elit. Assumenda facilis magni blanditiis enim tempora quis.</p>
            </div>
            </div>
            <div class="carousel-item">
              <div class="wrapper d-flex justify-content-center align-items-center flex-column">
                <i class="bi bi-square-fill"></i>
                <h1>Lorem ipsum</h1>
                <p>Lorem ipsum dolor sit amet consectetur, adipisicing elit. Assumenda facilis magni blanditiis enim tempora quis.</p>
            </div>
            </div>
            <div class="carousel-item">
              <div class="wrapper d-flex justify-content-center align-items-center flex-column">
                <i class="bi bi-square-fill"></i>
                <h1>Lorem ipsum</h1>
                <p>Lorem ipsum dolor sit amet consectetur, adipisicing elit. Assumenda facilis magni blanditiis enim tempora quis.</p>
            </div>
            </div>
          </div>
          <button
            class="carousel-control-prev"
            type="button"
            data-bs-target="#carouselExampleIndicators"
            data-bs-slide="prev"
          >
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
          </button>
          <button
            class="carousel-control-next"
            type="button"
            data-bs-target="#carouselExampleIndicators"
            data-bs-slide="next"
          >
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
          </button>
        </div>
      </div>
      <div class="our-partners">
        <h1 style="margin-bottom: 40px">Our partners</h1>
        <div class="logos d-flex justify-content-center align-items-center">
          <i class="bi bi-check-circle-fill"></i>
          <i class="bi bi-spotify"></i>
          <i class="bi bi-apple"></i>
          <i class="bi bi-star-fill"></i>
        </div>
      </div>
    </div>
  </div>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
<script>
    $('.dropOffInput').hide();
    $('.dropOffCheck').click(function(){
        $('.dropOffInput').toggle();
    });

    $('.driverAge').hide();
    $('.driverAgeCheck').click(function(){
        $('.driverAge').toggle();
    });
</script>
@endsection