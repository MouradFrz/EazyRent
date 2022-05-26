@extends('layouts.userLayout')
@section('content')
<div class="offer">

  <div class="container">
    <div class="offer_header">
      <h1>{{$vehicule->brand}} {{$vehicule->model}}</h1>
    </div>
    <div class="row">
      <div class="col-8">
        <div class="offer_media">
          <img src="{{asset('images/vehicules/imagePaths/'.$vehicule->imagePath)}}" alt="{{$vehicule->brand}} {{$vehicule->model}}" loading="lazy">
        </div>
        <form action="" method="post" id="reservation-form">
          @csrf
          <div class="row">
            <div class="col">
              <label for="vehicule" class="form-label">vehicule</label>
              <input type="text" value="{{$vehicule->brand}} {{$vehicule->model}}" class="form-control" disabled>
            </div>
            <div class="col">
              <label for="agency" class="form-label">agency</label>
              <input type="text" value="{{$vehicule->name}}" class="form-control" disabled>
            </div>
          </div>
          <div class="row">
            <div class="col">
              <label for="pickUpDate" class="form-label">pick up at</label>
              <input type="datetime-local" value="{{$pickUpDate}}" class="form-control" disabled>
            </div>
            <div class="col">
              <label for="drop Off Date" class="form-label">drop off at</label>
              <input type="datetime-local" value="{{$dropOffDate}}" class="form-control" disabled>
            </div>
          </div>
          <div class="row">
            <div class="col">
              <label for="daysNbr" class="form-label">days number</label>
              <input type="string"
              value="@php
              $diff = DateTime::createFromFormat('Y-m-j H:i', str_replace('T',' ', $dropOffDate))
              ->diff(DateTime::createFromFormat('Y-m-j H:i', str_replace('T',' ', $pickUpDate)));
              echo $diff->days;
              @endphp"
              class="form-control" disabled>
            </div>
            <div class="col">
              <label for="hoursNbr" class="form-label">hours number</label>
              <input type="number"
              value="@php
              $diff = DateTime::createFromFormat('Y-m-j H:i', str_replace('T',' ', $dropOffDate))
              ->diff(DateTime::createFromFormat('Y-m-j H:i', str_replace('T',' ', $pickUpDate)));
              echo $diff->h;
              @endphp"
              class="form-control" disabled>
            </div>
          </div>
          <div class="row">
            <div class="col">
              <label for="pricePerHour" class="form-label">price per hour</label>
              <input type="number" class="form-control" value="{{$vehicule->pricePerHour}}" disabled>
            </div>
            <div class="col">
              <label for="pricePerHour" class="form-label">price per day</label>
              <input type="number" class="form-control" value="{{$vehicule->pricePerDay}}" disabled>
            </div>
            <div class="col">
              <label for="totalPrice" class="form-label">total price</label>
              <input type="number" class="form-control" value="@php
              $diff = DateTime::createFromFormat('Y-m-j H:i', str_replace('T',' ', $dropOffDate))
              ->diff(DateTime::createFromFormat('Y-m-j H:i', str_replace('T',' ', $pickUpDate)));
              $days = $diff->days;
              $hours = $diff->h;
              $price = $vehicule -> pricePerHour * $hours + $vehicule -> pricePerDay * $days;
              echo $price;
              @endphp"
              disabled>
            </div>
          </div>
          <button class="custom-btn" onclick="event.preventDefault();" data-bs-toggle="modal" data-bs-target="#confirm">confirm booking</button>
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
                  <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">cancel</button>
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
