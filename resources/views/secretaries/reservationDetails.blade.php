@extends('layouts.workerLayout')

@section('headTags')
<title>booking details</title>
<link rel="stylesheet" href="{{asset('css/secretary/index.css')}}">
@endsection

@section('content')
<script>
  let reservations = document.querySelector('#reservations')
  reservations.classList.add('active')
</script>
<div class="reservation details">
  <div class="container mt-2">
    <a href="{{ route('secretary.getReservationRequests') }}" class="link link-no-decoration">
      <i class="fa-solid fa-arrow-left"></i>
      Go back
    </a>
    @if (Session::get('fail'))
    <div class="alert alert-danger alert-dismissible fade show w-100" role="alert">
      <strong>{{ Session::get('fail') }}</strong>
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif
    @if (Session::get('success'))
    <div class="alert alert-success alert-dismissible fade show w-100 " role="alert">
      <strong>{{ Session::get('success') }}</strong>
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif
    <h2 class="section-header">Reservation details</h2>
    <div class="row">
      <div class="col">
        <h3>client informations</h3>
        <p class="label">Full name:</p>
        <p class="value">{{ $booking->firstName }} {{ $booking->lastName }}</p>
        <p class="label">birthdate</p>
        <p class="value">{{$booking -> birthDate}}</p>
        <p class="label">Ban count:</p>
        <p class="value">
          @if($booking->nbBan == 0 )
          No bans
          @else
          {{ $booking->nbBan }}
          @endif
        </p>
        <p class="label">Identity card number</p>
        <p class="value">{{$booking -> idCard}}</p>
        <p class="label">Identity card image:</p>
          <img id="IdCardImage" class="id-card-image zoom"
            src="{{ $booking->idCardPath }}"  data-magnify-src="{{ $booking->idCardPath }}">

      </div>
      <div class="col">
        <h3>contact info</h3>
        <p class="label">Email:</p>
        <p class="value">{{ $booking->email }}</p>
        <p class="label">Phone number:</p>
        <p class="value">
          @if(!is_null($booking->phoneNumber))
          {{ $booking->phoneNumber }}
          @else
          Unavailable
          @endif
        </p>
      </div>
    </div>
    <hr>
    <div class="row">
      <div class="col">
        <h4>Car information:</h4>
        <p class="label">Car plate number</p>
        <p class="value">{{ $booking->plateNb }}</p>
        <p class="label">Car model:</p>
        <p class="value">{{ $booking->brand }} {{ $booking->model }}</p>
        <p class="label">Price:</p>
        <p class="value"> {{ $booking->pricePerDay }}DA/day, {{ $booking->pricePerHour }}DA/hour</p>
        <p class="label">Current garage address:</p>
        <p class="value">{{ $booking->address }}</p>
      </div>
      <div class="col">
        <h4>Booking information:</h4>
        <p class="label">Pick-up location:</p>
        <p class="value">{{ $booking->pickUpLocation }}</p>
        <p class="label">Drop-off location:</p>
        <p class="value">{{ $booking->dropOffLocation }}</p>
        <p class="label">Pick-up date:</p>
        <p class="value">{{ $booking->pickUpDate }}</p>
        <p class="label">Drop-off date:</p>
        <p class="value">{{ $booking->dropOffDate }}</p>
        <p class="label">Payement method:</p>
        <p class="value">{{ $booking->payementMethod }}</p>
        <p class="label">Duration:</p>
        <p class="value">{{ $interval }} </p>
        <p class="label">Reservation sent at:</p>
        <p class="value">{{ $booking->created_at }} </p>
      </div>
    </div>
    <div class="d-flex action">
      @if($booking->state=="REQUESTED")
      <form action="{{route('secretary.acceptBooking',$booking->bookingID)}}" method="POST" id="accept">@csrf</form>
      <button class="custom-btn custom-btn-success" onclick="document.querySelector('#accept').submit()">Accept request</button>
      <button class="custom-btn custom-btn-danger ms-2" data-bs-toggle="modal" data-bs-target="#declineBooking">Decline Request</button>

      @elseif($booking->state=="DECLINED")
      <p class="danger">You declined this request </p><br>
      <p class="label">Decline reason:</p>
      <p class="value">{{ $booking->declineReason }}</p>
      @else
      <p>You accepted this request at {{ $booking->updated_at }}</p>
      @endif
      <div class="modal fade" id="declineBooking" tabindex="-1" aria-labelledby="declineBookingLabel"
        aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="declineBookingLabel">Decline booking request</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{route('secretary.declineBooking', $booking->bookingID )}}" method="post">
              @csrf
              <div class="modal-body">
                <label for="decline-reason" class="form-label">Decline reason</label>
                <input type="text" name="declineReason" class="form-control">
                <div class="form-text">This step cannot be reversed</div>
                <span class="text-danger">
                  @error('declineReason')
                  {{ $message }}
                  @enderror
                </span>
              </div>
              <div class="modal-footer">
                <button type="submit" class="custom-btn custom-btn-danger">Decline booking</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection

@section('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" integrity="sha512-894YE6QWD5I59HgZOGReFYm4dnWc1Qt5NtvYSaNcOP+u1T9qYdvdihz0PPSiiqn/+/3e7Jo4EaG7TubfWGUrMQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/magnify/2.3.3/js/jquery.magnify.min.js" integrity="sha512-YKxHqn7D0M5knQJO2xKHZpCfZ+/Ta7qpEHgADN+AkY2U2Y4JJtlCEHzKWV5ZE87vZR3ipdzNJ4U/sfjIaoHMfw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script>
  $(document).ready(function() {
    $('.zoom').magnify({
      magnifiedWidth:640,
      magnifiedHeight:380,
    });
  });
  </script>

@endsection
