@extends('layouts.workerLayout')

@section('headTags')
<link rel="stylesheet" href="https://cdn.datatables.net/1.12.0/css/jquery.dataTables.css">
<link rel="stylesheet" href="{{ asset('css/garagist/index.css') }}">
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
                  
                   @foreach ($bookings as $index => $element)
                  <tr>
                    
                    <td>{{ $element->model }} {{ $element->brand }}</td>
                    <td>{{ $element->vehiculePlateNB }}</td>
                    <td>{{ $element->firstName }} {{ $element->lastName }}</td>
                    <td>{{ $element->address_address }}</td>
                    <td>{{ $element->dropOffDate }}</td>
                    <td style="position: relative" class="trigger"><p class="view-more fullname">View more</p>
                      <div class="dropmenu">
                        <div class="drop-align">
                          <div class="d-flex justify-content-between">
                            <p>Client:</p>
                            <p>{{ $element->firstName }} {{ $element->lastName }}</p>
                          </div>
                          <div class="d-flex justify-content-between">
                            <p>Vehicule:</p>
                            <p>{{ $element->brand }} {{ $element->model }}</p>
                          </div>
                          <div class="d-flex justify-content-between">
                            <p>Plate number:</p>
                            <p>{{ $element->plateNb }}</p>
                          </div>
                          <div class="d-flex justify-content-between">
                            <p>Pick up date:</p>
                            <p>{{ $element->pickUpDate }}</p>
                          </div>
                          <div class="d-flex justify-content-between">
                            <p>Pick up location:</p>
                            <p>{{ $pickUpLocations[$index]->address_address }}</p>
                          </div>
                          <div class="d-flex justify-content-between">
                            <p>Drop off date:</p>
                            <p>{{ $element->dropOffDate }}</p>
                          </div>
                          <div class="d-flex justify-content-between">
                            <p>Drop off location:</p>
                            <p>{{ $element->address_address }}</p>
                          </div>
                          <div class="d-flex justify-content-between">
                            <p>Payement method:</p>
                            <p>{{ $element->payementMethod }}</p>
                          </div>
                          <div class="d-flex justify-content-between">
                            <p>Accepted by:</p>
                            <p>{{ $element->secretaryUsername }}</p>
                          </div>
                        </div>
                      </div>
                    </td>

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