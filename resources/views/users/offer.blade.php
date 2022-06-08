@extends('layouts.userLayout')
@section('content')
<div class="offer">
  <div class="container">
    <form action="{{route('user.viewOffers')}}" method="POST" id="goBack">
      @csrf
      <div class="d-none">
        <input type="text" name="pickUpLng" value="{{session('pickUpLng')}}" />
        <input type="text" name="pickUpLat" value="{{session('pickUpLat')}}" />
        <input type="datetime-local" name="pickUpDate" value="{{session('pickUpString')}}" />
        <input type="datetime-local" name="dropOffDate" value="{{session('dropOffString')}}" />
      </div>
      <a type="submit" onclick="document.getElementById('goBack').submit()" class="link link_no_decoration"><i
          class="fa-solid fa-arrow-left"></i> Go back</a>
    </form>
    @if (Session::get('fail'))
    <div class="alert alert-danger w-100 alert-dismissible fade show" role="alert">
      <strong>{{ Session::get('fail') }}</strong>
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif
    @if (Session::get('success'))
    <div class="alert alert-success w-100 alert-dismissible fade show" role="alert">
      <strong>{{ Session::get('success') }}</strong>
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif
    <div class="row">
      <h1 class="section-header">{{$vehicule -> brand}} {{$vehicule -> model}}</h1>
      <div class="offer_media col-12 col-md-6 col-lg-8">
        <img src="{{asset('images/vehicules/imagePaths/'.$vehicule -> imagePath)}}"
          alt="{{$vehicule -> brand}} {{$vehicule -> model}}" loading="lazy">
      </div>
      <div class="offer_details col-12 col-md-6 col-lg-4">
        <h2>Vehicule info</h2>
        <table class="table table-striped">
          <tbody>
            <tr>
              <th scope="row">color : </th>
              <td>{{$vehicule -> color}}</td>
            </tr>
            <tr>
              <th scope="row">type : </th>
              <td>{{$vehicule -> type}}</td>
            </tr>
            <tr>
              <th scope="row">fuel : </th>
              <td>{{$vehicule -> fuel}}</td>
            </tr>
            <tr>
              <th scope="row">year : </th>
              <td>{{$vehicule -> year}}</td>
            </tr>
            <tr>
              <th scope="row">gear type : </th>
              <td>{{$vehicule -> gearType}}</td>
            </tr>
            <tr>
              <th scope="row">doors number : </th>
              <td>{{$vehicule -> doorsNb}}</td>
            </tr>
            <tr>
              <th scope="row">horse power : </th>
              <td>{{$vehicule -> horsePower}}</td>
            </tr>
            <tr>
              <th scope="row">air cooling : </th>
              <td>{{$vehicule -> airCooling}}</td>
            </tr>
            <tr>
              <th scope="row">rating : </th>
              <td>{{$vehicule -> rating}}</td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
    @if(Auth::guard('web')->check())
    @if (Session::get('success'))
    @else
    <h2>rent this car</h2>
    <div class="offer_rent">
      <form action="{{route('user.book') }}" method="post" id="reservation-form" class="reservation-form">
        @csrf
        <div class="row">
          <div class="col">
            <label for="vehicule" class="form-label">vehicule</label>
            <input type="text" value="{{$vehicule -> brand}} {{$vehicule -> model}}" class="form-control" disabled>
          </div>
          <div class="col">
            <label for="agency" class="form-label">agency</label>
            <input type="text" value="{{$agencyName}}" class="form-control" disabled>
          </div>
        </div>
        <div class="row">
          <div class="col">
            <label for="pickUpDate" class="form-label">pick up at</label>
            <input type="datetime-local" name="pickUpDate" value="{{session('pickUpString')}}" class="form-control"
              disabled>
          </div>
          <div class="col">
            <label for="drop Off Date" class="form-label">drop off at</label>
            <input type="datetime-local" name="dropOffDate" value="{{session('dropOffString')}}" class="form-control"
              disabled>
          </div>
        </div>
        <div class="row">
          <div class="col">
            <label for="daysNbr" class="form-label">days count</label>
            <input type="string" value="@php
              $diff = session('dropOffDate')->diff(session('pickUpDate'));
              $days =  $diff->days;
              echo $days;
              @endphp" class="form-control" disabled>
          </div>
          <div class="col">
            <label for="hoursNbr" class="form-label">hours count</label>
            <input type="number" value="@php
              $hours = $diff->h;
              echo $hours;
              @endphp" class="form-control" disabled>
          </div>
        </div>
        <div class="row">
          <div class="col">
            <label for="pricePerHour" class="form-label">price per hour</label>
            <input type="number" class="form-control" value="{{$vehicule -> pricePerHour}}" disabled>
          </div>
          <div class="col">
            <label for="pricePerDay" class="form-label">price per day</label>
            <input type="number" class="form-control" value="{{$vehicule -> pricePerDay}}" disabled>
          </div>
          <div class="col">
            <label for="totalPrice" class="form-label">total price</label>
            <input type="number" class="form-control" value="@php
              $price = $vehicule -> pricePerHour * $hours + $vehicule -> pricePerDay * $days;
              echo $price;
              @endphp" disabled>
          </div>
        </div>
        <div class="row">
          <div class="col">
            <label for="pickUpLocation" class="form-group">pick up at</label>
            <select id="pickUpLocation" name="pickUpLocation" class="form-select" aria-label="pickUpLocation">
              <option selected value="">sellect a pick up location</option>
              @foreach ($pickUpLocations as $address)
              <option value="{{$address -> id}}">{{$address -> address_address}}</option>
              @endforeach
            </select>
            @error('pickUpLocation')<span style="color: red">{{$message}}</span>@enderror
          </div>
          <div class="col">
            <label for="dropOffLocation" class="form-group">drop off at</label>
            <select id="dropOffLocation" name="dropOffLocation" class="form-select" aria-label="dropOffLocation">
              <option selected value="">sellect a drop off location</option>
              @foreach ($pickUpLocations as $address)
              <option value="{{$address -> id}}">{{$address -> address_address}}</option>
              @endforeach
            </select>
            @error('dropOffLocation')<span style="color: red">{{$message}}</span>@enderror
          </div>
        </div>
        <button class="custom-btn custom-btn-dark mt-4" onclick="event.preventDefault();" data-bs-toggle="modal"
          data-bs-target="#confirm">Confirm booking</button>
        <div class="modal fade" id="confirm" tabindex="-1" aria-labelledby="confirmLabel" aria-hidden="true">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="confirmLabel">Confirm</h5>
              </div>
              <div class="modal-body">
                <p>Are you sure you want to book <strong>{{$vehicule -> brand}} {{$vehicule -> model}}</strong>
                  for <strong>{{$days}} day @if($hours!=0) and {{$hours}} hour @endif </strong> start at
                  <strong>{{str_replace('T', ' ', session('pickUpString'))}} </strong>
                </p>
                </p>
                <p>Total price: <strong>{{$price}} DZD</strong></p>
              </div>
              <div class="modal-footer d-flex justify-content-between">
                <button type="button" class="link link-secondary" data-bs-dismiss="modal"
                  onclick="event.preventDefault();">Cancel</button>
                <button type="button" class="link link-success"
                  onclick="document.getElementById('reservation-form').submit()">Confirm my choice</button>
              </div>
            </div>
          </div>
        </div>
      </form>
    </div>
    @endif
    @else
    <div class="offer_rent">
      <strong>you have to log in before booking a vehicule
        <a href="{{ route('user.login') }}" id="log-in" class="link">log in now!</a>
      </strong>
    </div>
    @endif
  </div>

</div>
@endsection
@section('script')
@endsection
