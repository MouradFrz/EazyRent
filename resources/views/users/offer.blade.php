@extends('layouts.userLayout')
@section('content')
<div class="offer">
  <div class="container">
    <div class="offer_header">
      <h1>{{$vehicule->brand}} {{$vehicule->model}}</h1>
    </div>
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
      <div class="col-8">
        <div class="offer_media">
          <img src="{{asset('images/vehicules/imagePaths/'.$vehicule->imagePath)}}"
            alt="{{$vehicule->brand}} {{$vehicule->model}}" loading="lazy">
        </div>
        <form action="{{route('user.book') }}" method="post"
          id="reservation-form">
          @csrf
          <div class="row">
            <div class="col">
              <label for="vehicule" class="form-label">vehicule</label>
              <input type="text" value="{{$vehicule->brand}} {{$vehicule->model}}" class="form-control" disabled>
            </div>
            <div class="col">
              <label for="agency" class="form-label">agency</label>
              <input type="text" value="{{session('agencyName')}}" class="form-control" disabled>
            </div>
          </div>
          <div class="row">
            <div class="col">
              <label for="pickUpDate" class="form-label">pick up at</label>
              <input type="datetime-local" name="pickUpDate" value="{{session('pickUpString')}}" class="form-control" disabled>
            </div>
            <div class="col">
              <label for="drop Off Date" class="form-label">drop off at</label>
              <input type="datetime-local" name="dropOffDate" value="{{session('dropOffString')}}" class="form-control" disabled>
            </div>
          </div>
          <div class="row">
            <div class="col">
              <label for="daysNbr" class="form-label">days number</label>
              <input type="string" value="@php
              $diff = session('dropOffDate')->diff(session('pickUpDate'));
              $days =  $diff->days;
              echo $days;
              @endphp" class="form-control" disabled>
            </div>
            <div class="col">
              <label for="hoursNbr" class="form-label">hours number</label>
              <input type="number" value="@php
              // $diff = session('dropOffDate')->diff(session('pickUpDate'));
              $hours = $diff->h;
              echo $hours;
              @endphp" class="form-control" disabled>
            </div>
          </div>
          <div class="row">
            <div class="col">
              <label for="pricePerHour" class="form-label">price per hour</label>
              <input type="number" class="form-control" value="{{$vehicule->pricePerHour}}" disabled>
            </div>
            <div class="col">
              <label for="pricePerDay" class="form-label">price per day</label>
              <input type="number" class="form-control" value="{{$vehicule->pricePerDay}}" disabled>
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
          <button class="custom-btn" onclick="event.preventDefault();" data-bs-toggle="modal"
            data-bs-target="#confirm">confirm booking</button>
          <div class="modal fade" id="confirm" tabindex="-1" aria-labelledby="confirmLabel" aria-hidden="true">
            <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="confirmLabel">Confirm choise</h5>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                  <p>you are on one step to book this car</p>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" onclick="event.preventDefault();">cancel</button>
                  <button type="button" class="btn btn-primary"
                    onclick="document.getElementById('reservation-form').submit()">confirm my choise</button>
                </div>
              </div>
            </div>
          </div>
        </form>
      </div>
      <div class="offer_details col-4">
        <table class="table table-striped">
          <tbody>
            <tr>
              <th scope="row">color : </th>
              <td>{{$vehicule->color}}</td>
            </tr>
            <tr>
              <th scope="row">type : </th>
              <td>{{$vehicule->type}}</td>
            </tr>
            <tr>
              <th scope="row">fuel : </th>
              <td>{{$vehicule->fuel}}</td>
            </tr>
            <tr>
              <th scope="row">year : </th>
              <td>{{$vehicule->year}}</td>
            </tr>
            <tr>
              <th scope="row">gear type : </th>
              <td>{{$vehicule->gearType}}</td>
            </tr>
            <tr>
              <th scope="row">doors number : </th>
              <td>{{$vehicule->doorsNb}}</td>
            </tr>
            <tr>
              <th scope="row">horse power : </th>
              <td>{{$vehicule->horsePower}}</td>
            </tr>
            <tr>
              <th scope="row">air cooling : </th>
              <td>{{$vehicule->airCooling}}</td>
            </tr>
            <tr>
              <th scope="row">rating : </th>
              <td>{{$vehicule->rating}}</td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </div>

</div>
@endsection
@section('script')
@endsection
