@extends('layouts.workerLayout')

@section('headTags')

@endsection

@section('content')
<div>
  <div class="container">
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
    <h2 class="m-3">Reservation details</h2>
    <hr>
    <div class="row">
      <div class="col">
        <h4>Clients information:</h4>
        <p class="tag">Full name:</p>
        <p class="value">{{ $booking->firstName }} {{ $booking->lastName }}</p>
        <p class="tag">Email:</p>
        <p class="value">{{ $booking->email }}</p>
        <p class="tag">Phone number:</p>
        <p class="value">
          @if(!is_null($booking->phoneNumber))
          {{ $booking->phoneNumber }}
          @else
          Unavailable
          @endif
        </p>
        <p class="tag">Ban count:</p>
        <p class="value">{{ $booking->nbBan }}</p>
        <p class="tag">Identity card image:</p>
        <img src="{{ asset('images/users/idCardImages/'. $booking->idCardPath) }}" alt="" style="width: 200px">
      </div>
      <div class="col">
        <h4>Car information:</h4>
        <p class="tag">Car model:</p>
        <p class="value">{{ $booking->brand }} {{ $booking->model }}</p>
        <p class="tag">Car condtion:</p>
        <p class="value">{{ $booking->physicalState }}</p>
        <p class="tag">Availability:</p>
        <p class="value">{{ $booking->availability }}</p>
        <p class="tag">Price:</p>
        <p class="value"> {{ $booking->pricePerDay }}DA/day, {{ $booking->pricePerHour }}DA/hour</p>
        <p class="tag">Current garage address:</p>
        <p class="value">{{ $booking->address }}</p>
      </div>
    </div>
    <hr>
    <div class="row">
      <div class="col">
        <h4>Booking information:</h4>
        <p class="tag">Pick-up location:</p>
        <p class="value">{{ $booking->pickUpLocation }}</p>
        <p class="tag">Drop-off location:</p>
        <p class="value">{{ $booking->dropOffLocation }}</p>
        <p class="tag">Pick-up date:</p>
        <p class="value">{{ $booking->pickUpDate }}</p>
        <p class="tag">Drop-off date:</p>
        <p class="value">{{ $booking->dropOffDate }}</p>
        <p class="tag">Payement method:</p>
        <p class="value">{{ $booking->payementMethod }}</p>
        <p class="tag">Duration:</p>
        <p class="value">{{ $interval }} </p>
        <p class="tag">Reservation sent at:</p>
        <p class="value">{{ $booking->created_at }} </p>
      </div>
    </div>
    <div class=" d-flex g-5">
      @if($booking->state=="REQUESTED")
      <form action="{{route('secretary.acceptBooking',$booking->bookingID)}}" method="POST" id="accept">@csrf</form>
      <button class="btn btn-primary"  onclick="document.querySelector('#accept').submit()" >Accept booking request</button>
      <button class="btn btn-danger ms-2" data-bs-toggle="modal" data-bs-target="#declineBooking">Decline
        booking request</button>
      
      @elseif($booking->state=="DECLINED")
      <p style="color: red;display:block">You declined this request </p><br>
      <p class="tag">Decline reason:</p>
      
      <p class="value">{{ $booking->declineReason }}</p>
      @else
        <p>You accepted this request at {{ $request->updated_at }}</p>
      @endif
      
     
      <div class="modal fade" id="declineBooking" tabindex="-1" aria-labelledby="declineBookingLabel"
        aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="declineBookingLabel">decline booking request</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{route('secretary.declineBooking', $booking->bookingID )}}" method="post">
              @csrf
              <div class="modal-body">
                <label for="decline-reason" class="form-label">decline reason</label>
                <input type="text" name="declineReason" class="form-control">
                <div class="form-text">this step cannot be reversed</div>
                <span class="text-danger">
                  @error('declineReason')
                  {{ $message }}
                  @enderror
                </span>
              </div>
              <div class="modal-footer">
                <button type="submit" class="btn btn-danger">decline booking</button>
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

@endsection
