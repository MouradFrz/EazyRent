@extends('layouts.workerLayout')

@section('headTags')
<link rel="stylesheet" href="https://cdn.datatables.net/1.12.0/css/jquery.dataTables.css">
@endsection

@section('content')
    <div>
        <div class="container">
            <h2 class="my-3">On going reservations</h2>
            <hr>
            <table class="table table-striped" id="bookingTable">
                <thead>
                  <tr>
                    <th>Vehicle</th>
                    <th>Plate number</th>
                    <th>Clients full name</th>
                    <th>Drop-off location</th>
                    <th>Drop-off date</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody>
                  
                   @foreach ($bookings as $element)
                  <tr>
                    <td>{{ $element->model }} {{ $element->brand }}</td>
                    <td>{{ $element->vehiculePlateNB }}</td>
                    <td>{{ $element->firstName }} {{ $element->lastName }}</td>
                    <td>{{ $element->address_address }}</td>
                    <td>{{ $element->dropOffDate }}</td>
                    <td><a href="">View details</a></td>

                  </tr>
                  @endforeach
                </tbody>
              
              </table>
              {{$bookings->links()}}
        </div>
    </div>
@endsection

@section('scripts')
<script src="https://code.jquery.com/jquery-3.6.0.slim.min.js" integrity="sha256-u7e5khyithlIdTpu22PHhENmPcRdFiHRjhAuHcs05RI=" crossorigin="anonymous"></script>
<script src="https://cdn.datatables.net/1.12.0/js/jquery.dataTables.min.js" crossorigin="anonymous"></script>
<script>
     let restable = new DataTable('#bookingTable');
</script>
@endsection