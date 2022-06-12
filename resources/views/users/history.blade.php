@extends('layouts.userLayout')
@section('head')
@endsection

@section('content')
<div class="modal fade" id="complaintModal" tabindex="-1" aria-labelledby="complaintLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Sending a complaint</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <p>This complaint will be sent to the agency's owner</p>
        <form action="{{ route('user.sendComplaint') }}" method="POST" id="complaint">
          @csrf
          <input type="text" id="agencyID" style="display: none" name="agencyID">
          <input type="text" id="bookingID" style="display: none" name="bookingID">
          <select name="type" id="">
            <option value="Bad Behavior">Bad behavior</option>
            <option value="Missed appointement">Missed appointement</option>
            <option value="Bad vehicule state">Bad vehicule state</option>
          </select>
          <label for="">Message:</label>
          <textarea name="message" style="resize: none;height:300px" class="inputs"></textarea>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="link link-secondary" data-bs-dismiss="modal">Close</button>
        <button type="button" class="link" onclick="document.querySelector('#complaint').submit()">Confirm</button>
      </div>
    </div>
  </div>
</div>
<div class="modal fade" id="vehicleModal" tabindex="-1" aria-labelledby="vehicleLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Rating a vehicle</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form action="{{ route('user.rateVehicle') }}" method="POST" id="vehicle">
          @csrf
          <label for="">Rating (/5)</label>
          <input type="number" min="0" max="5" step="0.5" name="rating" class="inputs">
          <input type="text" id="vehicleRatingBookingID" style="display: none" name="bookingID">
          <label for="">Comment:</label>
          <textarea name="comment" style="resize: none;height:200px" class="inputs"></textarea>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="link link-secondary" data-bs-dismiss="modal">Close</button>
        <button type="button" class="link" onclick="document.querySelector('#vehicle').submit()">Confirm</button>
      </div>
    </div>
  </div>
</div>
<div class="modal fade" id="agencyModal" tabindex="-1" aria-labelledby="agencyLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Rating an agency</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">

        <form action="{{ route('user.rateAgency') }}" method="POST" id="agency">
          @csrf
          <label for="">Rating (/5)</label>
          <input type="number" min="0" max="5" step="0.5" name="rating" class="inputs">
          <input type="text" id="agencyRatingBookingID" style="display: none" name="bookingID">
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="link link-secondary" data-bs-dismiss="modal">Close</button>
        <button type="button" class="link" onclick="document.querySelector('#agency').submit()">Confirm</button>
      </div>
    </div>
  </div>
</div>
<div class="history">
  <div class="container">
    <h1 class="section-header">booking history</h1>
    @if (Session::get("message"))
    <div class="alert alert-success w-100 alert-dismissible fade show" role="alert">
      {{ Session::get('message') }}
      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
      </button>
    </div>
    @endif
    @if (count($bookings) != 0)
    <table class="history_table table table-striped">
      <thead>
        <tr>
          <th>Car</th>
          <th>Booking</th>
          <th>Booked at</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
        @foreach ($bookings as $booking)
        <tr>
          <td>{{ $booking->brand }} {{ $booking->model }}</td>
          <td class="booking-state {{ $booking->state }}">{{ $booking->state }}</td>
          <td>{{ $booking->created_at }}</td>
          <td class="history_actions">
            @if ($booking->state == 'DECLINED')
            <a href="{{ route('user.bookingDetails', $booking->bookingID) }}" class="custom-btn custom-btn-danger">
              View refuse reason
            </a>
            @elseif ($booking->state == 'ACCEPTED')
            <a href="{{ route('user.bookingDetails', $booking->bookingID) }}" class="custom-btn custom-btn-success">
              Sign Contract
            </a>
            @elseif($booking->state == 'SIGNED' && $booking->pickUpDate < now())
            <a href="{{ route('user.checkFace', $booking->bookingID) }}" class="custom-btn custom-btn-success">
              Simulation
            </a>
            @elseif($booking->state == 'ON GOING' && $booking->dropOffDate < now())
            <a href="{{ route('user.bookingDetails', $booking->bookingID) }}" class="custom-btn custom-btn-danger">
              Vehicule needs to be returned
            </a>
            @elseif ($booking->state == 'FINISHED')
              @if (!isset($booking->vehiculeRating))
              <button class="link vehiculeRatingBtns" data-bs-toggle="modal"
                data-bs-target="#vehicleModal" data-bookingid="{{ $booking->bookingID }}">Vehicule reveiw</button>
              @else
              <button class="link link-secondary" disabled>Already Rated : {{ $booking->vehiculeRating
                }}</button>
              @endif
              @if (!isset($booking->clientRatesSecretary))
              <button class="link agencyRatingBtns" data-bookingid="{{ $booking->bookingID }}"
                data-bs-toggle="modal" data-bs-target="#agencyModal">Agency reveiw</button>
              @else
              <button class="link link-secondary" disabled>Agency Rated : {{ $booking->clientRatesSecretary
                }}</button>
              @endif
              @if(!isset($booking->complaintID))
              <button class="link complaintBtns" data-bookingid="{{ $booking->bookingID }}"
                data-agencyid="{{ $booking->agencyID }}" data-bs-toggle="modal" data-bs-target="#complaintModal">Send
                complaint</button>
              @else
              <button class="link link-secondary" disabled>Complaint Sent</button>
              @endif
              <a href="{{ route('user.bookingDetails', $booking->bookingID) }}" class="link link-underline">
                View details >
              </a>
              @else
              <a href="{{ route('user.bookingDetails', $booking->bookingID) }}" class="link link-underline">
                View details >
              </a>
            @endif
          </td>
        </tr>
        @endforeach
      </tbody>
    </table>
    @else
    <div class="no-bookings">
      <div class="no-bookings_media">
        <i class="fa-solid fa-triangle-exclamation"></i>
      </div>
      <div class="no-bookings_content">
        <p class="text-center">You have no bookings yet.</p>
      </div>
    </div>
    @endif
  </div>
</div>
@endsection

@section('script')
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"
  integrity="sha512-894YE6QWD5I59HgZOGReFYm4dnWc1Qt5NtvYSaNcOP+u1T9qYdvdihz0PPSiiqn/+/3e7Jo4EaG7TubfWGUrMQ=="
  crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script>
  const agencyID = document.querySelector('#agencyID')
    const bookingID = document.querySelector('#bookingID')
    const vehicleRatingBookingID = document.querySelector('#vehicleRatingBookingID')
    const agencyRatingBookingID = document.querySelector('#agencyRatingBookingID')
    const complaintBtns = document.querySelectorAll('.complaintBtns')
    const vehiculeRatingBtns = document.querySelectorAll('.vehiculeRatingBtns')
    const agencyRatingBtns = document.querySelectorAll('.agencyRatingBtns')
    complaintBtns.forEach((e)=>{
        e.addEventListener('click',()=>{
            agencyID.value =e.dataset.agencyid
            bookingID.value=e.dataset.bookingid
        })
    })
    vehiculeRatingBtns.forEach((e)=>{
        e.addEventListener('click',()=>{
            vehicleRatingBookingID.value = e.dataset.bookingid
            console.log(e.dataset.bookingid)
        })
    })

    agencyRatingBtns.forEach((e)=>{
        e.addEventListener('click',()=>{
            agencyRatingBookingID.value = e.dataset.bookingid

        })
    })

</script>
<script>
  $("[type='number']").keypress(function (evt) {
    evt.preventDefault();
});
</script>
@endsection
