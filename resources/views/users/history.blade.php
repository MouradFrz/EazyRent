@extends('layouts.userLayout')

@section('head')
    <style>
        .content {
            min-height: 100vh;
        }

        table {
            width: 100%;
        }
    </style>
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
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="button" class="btn btn-success" onclick="document.querySelector('#complaint').submit()">Confirm</button>
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
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="button" class="btn btn-success" onclick="document.querySelector('#vehicle').submit()">Confirm</button>
        </div>
      </div>
    </div>
  </div>
    <div>
        <div class="container content">
            <h2>My bookings</h2>
            @if (Session::get("message"))
            <div class="alert alert-success w-100 " role="alert">
              {{ Session::get('message') }}
          </div>
            @endif
            @if (count($bookings) != 0)
                <table class="table table-striped table-hover ">
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

                                <td>
                                    <p
                                        @if ($booking->state == 'REQUESTED') class="bg-success p-1 rounded  fw-bold" style="display: inline"
                                @elseif($booking->state == 'DECLINED')
                                class="bg-danger p-1 rounded  fw-bold" style="display: inline"
                                @elseif($booking->state == 'ACCEPTED')
                                class="bg-success p-1 rounded  fw-bold" style="display: inline"
                                @elseif($booking->state == 'SIGNED')
                                class="bg-info p-1 rounded  fw-bold" style="display: inline"
                                @elseif($booking->state == 'CANCELED')
                                class="bg-warning p-1 rounded  fw-bold" style="display: inline"
                                @elseif($booking->state == 'ON GOING')
                                class="bg-success p-1 rounded  fw-bold" style="display: inline"
                                @elseif($booking->state == 'FINISHED')
                                class="bg-secondary p-1 rounded  fw-bold" style="display: inline" @endif>
                                        {{ $booking->state }}</p>
                                </td>
                                <td>{{ $booking->created_at }}  </td>
                                <td>
                                    @if ($booking->state == 'DECLINED')
                                        <a href="{{ route('user.bookingDetails', $booking->bookingID) }}"
                                            class="btn btn-warning btn-sm">View refuse reason</a>
                                    @elseif ($booking->state == 'ACCEPTED')
                                        <a href="{{ route('user.bookingDetails', $booking->bookingID) }}"
                                            class="btn btn-success btn-sm">Sign Contract</a>
                                    @elseif($booking->state == 'SIGNED' && $booking->pickUpDate < now())
                                        <a href="{{ route('user.checkFace', $booking->bookingID) }}"
                                            class="btn btn-success btn-sm">Simulation</a>
                                    @elseif($booking->state == 'ON GOING' && $booking->dropOffDate < now())
                                        <a href="{{ route('user.bookingDetails', $booking->bookingID) }}"
                                            class="btn btn-danger btn-sm">Vehicule needs to be returned</a>
                                    @elseif ($booking->state == 'FINISHED')
                                        @if (!isset($booking->vehiculeRating))
                                        <button href="" class="btn btn-primary btn-sm vehiculeRatingBtns" data-bs-toggle="modal" data-bs-target="#vehicleModal" data-bookingid="{{ $booking->bookingID }}" >Vehicule reveiw</button>
                                        @else
                                        <button href="" class="btn btn-secondary btn-sm" disabled >Already Rated : {{ $booking->vehiculeRating }}</button>
                                        @endif
                                        
                                        <button href="" class="btn btn-primary btn-sm">Agency reveiw</button>
                                        @if(!isset($booking->complaintID))
                                        <button class="btn btn-primary btn-sm complaintBtns" data-bookingid="{{ $booking->bookingID }}" data-agencyid="{{ $booking->agencyID }}" data-bs-toggle="modal" data-bs-target="#complaintModal">Send complaint</button>
                                        @else
                                        <button class="btn btn-secondary btn-sm" disabled>Complaint Sent</button>
                                        @endif
                                        <a href="{{ route('user.bookingDetails', $booking->bookingID) }}"
                                            class="btn btn-primary btn-sm">View details</a>
                                    @else
                                        <a href="{{ route('user.bookingDetails', $booking->bookingID) }}"
                                            class="btn btn-primary btn-sm">View details</a>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <p class="text-center fs-1 fw-bold">You have no bookings yet.</p>
                <hr>
            @endif


        </div>
    </div>
@endsection

@section('script')
<script>
    const agencyID = document.querySelector('#agencyID')
    const bookingID = document.querySelector('#bookingID')
    const vehicleRatingBookingID = document.querySelector('#vehicleRatingBookingID')
    const complaintBtns = document.querySelectorAll('.complaintBtns')
    const vehiculeRatingBtns = document.querySelectorAll('.vehiculeRatingBtns')
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

</script>
@endsection
