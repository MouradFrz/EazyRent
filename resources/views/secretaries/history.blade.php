@extends('layouts.workerLayout')
@section('scripts')
<script src="https://code.jquery.com/jquery-3.6.0.slim.min.js" integrity="sha256-u7e5khyithlIdTpu22PHhENmPcRdFiHRjhAuHcs05RI=" crossorigin="anonymous"></script>
<script src="https://cdn.datatables.net/1.12.0/js/jquery.dataTables.min.js" crossorigin="anonymous"></script>
<script>
     let booktable = new DataTable('#booktable');
</script>
@endsection
@section('content')
<div>
    <div class="container">
        <h2 class="my-3">History</h2>
        <hr>
        <table class="table table-striped" id="booktable">
            <thead>
              <tr>
                <th>Clients full name</th>
                <th>Plate number</th>
                <th>Reservation's state</th>
                <th>Request sent at</th>
                <th>Answered at</th>
                <th>Banned</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>
              
               @foreach ($bookings as $element)
             
              <tr>
                <td>{{ $element->firstName }} {{ $element->lastName }}</td>
                <td>{{ $element->vehiculePlateNB }}</td>
                <td>{{ $element->state }}</td>
                <td>{{ $element->created_at}}</td>
                <td>{{ $element->updated_at }}</td>
                <td>YES/NO</td>
                <td><a href="{{ route('secretary.reservationDetails',$element->bookingID) }}">View details</a></td>
                <td>
                  
                </td>
              </tr>
              @endforeach
            </tbody>
          
          </table>
          {{$bookings->links()}}
    </div>
  
</div>

@endsection

@section('headTags')
<link rel="stylesheet" href="https://cdn.datatables.net/1.12.0/css/jquery.dataTables.css">
@endsection

