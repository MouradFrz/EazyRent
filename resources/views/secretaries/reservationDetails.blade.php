@extends('layouts.workerLayout')

@section('headTags')
    
@endsection

@section('content')
    <div>
        <div class="container">
            <h2 class="m-3">Reservation details</h2>
            <hr>
            <div class="row" >
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
            <div class=" d-flex g-5" >
                <button class="btn btn-secondary ">Decline reservation</button>
                <button class="btn btn-success ms-2">Accept reservation</button>
                
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    
@endsection