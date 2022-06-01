@extends('layouts.userLayout')

@section('head')
    <style>
        .booking{
            padding: 10px 0;
            border-bottom: 1px solid gray;
        }
    </style>
@endsection

@section('content')
    <div>
        <div class="container">
            <h2>My bookings</h2>
            <div class="booking d-flex justify-content-between">
                <p>Car</p>
                <p>Booking state</p>
                <p>Booked at</p>             
                <p>Actions</p>
            </div>
            @if (count($bookings)!=0)
                @foreach ($bookings as $booking)
                <div class="booking d-flex justify-content-between">
                    <p>{{ $booking->brand }} {{ $booking->model }}</p>
                    <p>{{ $booking->state }}</p>
                    <p>{{ $booking->created_at }}</p>
                    <div>
                        @if($booking->state == "DECLINED")
                        <a href="{{ route('user.bookingDetails',$booking->bookingID) }}" class="btn btn-warning">View refuse reason</a>
                        @elseif ($booking->state == "ACCEPTED")
                        <a href="{{ route('user.bookingDetails',$booking->bookingID) }}" class="btn btn-success">Sign Contract</a>
                        @else
                        <a href="{{ route('user.bookingDetails',$booking->bookingID) }}" class="btn btn-primary">View details</a>
                        @endif
                    </div>
                </div>
                @endforeach 
            @else
                <p>You have no reservations</p>
                
            @endif
           
          
        </div>
    </div>
@endsection

@section('script')
    
@endsection