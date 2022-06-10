@extends('layouts.userLayout')

@section('head')
    <style>
        .content{
            min-height: 100vh;
        }
        table {
            width: 100%;
        }

    </style>
@endsection

@section('content')
    <div>
        <div class="container content">
            <h2>My bookings</h2>


            @if (count($bookings) != 0)
                <table class="table">
                    <tr>
                        <th>Car</th>
                        <th>Booking</th>
                        <th>Booked at</th>
                        <th>Actions</th>
                    </tr>
                    @foreach ($bookings as $booking)
                        <tr>
                            <td>{{ $booking->brand }} {{ $booking->model }}</td>
                            
                            <td> <p 
                                @if ($booking->state =="REQUESTED")
                                class="bg-success p-1 rounded  fw-bold" style="display: inline"
                                @elseif($booking->state =="DECLINED")
                                class="bg-danger p-1 rounded  fw-bold" style="display: inline"
                                @elseif($booking->state =="ACCEPTED")
                                class="bg-success p-1 rounded  fw-bold" style="display: inline"
                                @elseif($booking->state =="SIGNED")
                                class="bg-info p-1 rounded  fw-bold" style="display: inline"
                                @elseif($booking->state =="CANCELED")
                                class="bg-warning p-1 rounded  fw-bold" style="display: inline"
                                @elseif($booking->state =="ON GOING")
                                class="bg-success p-1 rounded  fw-bold" style="display: inline"
                                @elseif($booking->state =="FINISHED")
                                class="bg-secondary p-1 rounded  fw-bold" style="display: inline"
                                @endif
                                > {{ $booking->state  }}</p></td>
                            <td>{{ $booking->created_at }}</td>
                            <td>
                                @if ($booking->state == 'DECLINED')
                                    <a href="{{ route('user.bookingDetails', $booking->bookingID) }}"
                                        class="btn btn-warning btn-sm">View refuse reason</a>
                                @elseif ($booking->state == 'ACCEPTED')
                                    <a href="{{ route('user.bookingDetails', $booking->bookingID) }}"
                                        class="btn btn-success btn-sm">Sign Contract</a>
                                @elseif($booking->state == 'SIGNED' && $booking->pickUpDate < now())
                                    <a href="{{ route('user.checkFace', $booking->bookingID) }}"
                                        class="btn btn-succes btn-sms">Simulation</a>
                                @elseif($booking->state == 'ON GOING' && $booking->dropOffDate < now())
                                    <a href="{{ route('user.bookingDetails', $booking->bookingID) }}"
                                        class="btn btn-danger btn-sm">Vehicule needs to be returned</a>
                                @else
                                    <a href="{{ route('user.bookingDetails', $booking->bookingID) }}"
                                        class="btn btn-primary btn-sm">View details</a>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </table>
            @else
                <p class="text-center fs-1 fw-bold">You have no bookings yet.</p>
                <hr>
            @endif


        </div>
    </div>
@endsection

@section('script')
@endsection
