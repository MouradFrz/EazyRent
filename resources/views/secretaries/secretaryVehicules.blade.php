
@extends('layouts.workerLayout')
@section('headTags')
<link rel="stylesheet" href="{{ asset('css/app.css') }}">
<link rel="stylesheet" href="{{ asset('css/owner/index.css') }}">
@endsection
 @section('content')

 {{-- <div class="modal fade" id="exampleModal1" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">You are about to delete this vehicle </h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
       <p>Are you sure you want to delete this vehicle ?</p> 
      </div>
      <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
          <button type="button" class="btn btn-danger" onclick="document.querySelector('#form').submit()">Confirm</button>
          <form action="{{ route('secretary.deleteVehicule',1) }}" id="form" method="POST">@csrf</form>
        </div>
    </div>
  </div>
</div>
<div class="modal fade" id="exampleModal2" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Change Vehicule State</h5>
      </div>
      <div class="modal-body">
      </div>
      <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="button" class="btn btn-danger" onclick="document.querySelector('#form').submit()">Change</button>
          <form action="" id="form" method="POST">@csrf</form>
        </div>
    </div>
  </div>
</div> --}}

 <div class="py-4">
     <div class="container">
        <h2>Vehicles list</h2>
         <div class="cards">
          @if (count($vehicules)!=0)
             @foreach ($vehicules as $vehicule)
                <div class="card-custom">
                  <ul class="p-0">
                    <img src="{{asset('images/vehicules/imagePaths/'.$vehicule->imagePath  )}}" alt="" style="max-height:200px; float:center;">
                    <li class="mt-3">Vehicule: <span class="value">{{$vehicule->brand}} {{ $vehicule->model }}</span></li>
                    <li>Plate number: <span class="value">{{ $vehicule->plateNb }}</span></li>
                    <li>Garage ID: <span class="value">{{ $vehicule->garageID }}</span></li>
                    <li><a href="{{ route('secretary.vehiculeDetails', $vehicule->plateNb) }}">View more</a></span></li>

                    @foreach ($bookings as $booking)

                      @if ($booking->vehiculePlateNB == $vehicule->plateNb)
                              @if ($booking->state=='REQUESTED' || $booking->state=='ACCEPTED' || $booking->state=='SIGNED' || $booking->state=='ON GOING')
                                                
                                @if ($vehicule->availability)
                                <button type="button" class="btn btn-warning my-3" disabled >Set unavailable</button>
                                @else
                                <button type="button" class="btn btn-success my-3" disabled >Set available</button>
                                @endif
                                @break
                              @else
                                @if ($vehicule->availability)
                                <button type="button" class="btn btn-warning my-3" onclick="document.querySelector('#form{{ $vehicule->plateNb }}').submit()" >Set unavailable</button>
                                @else
                                <button type="button" class="btn btn-success my-3" onclick="document.querySelector('#form{{ $vehicule->plateNb }}').submit()" >Set available</button>
                                @endif
                                @break
                          @endif
                      @else
                      @if ($loop->index==count($bookings)-1)
                      @if ($vehicule->availability)
                      <button type="button" class="btn btn-warning my-3" onclick="document.querySelector('#form{{ $vehicule->plateNb }}').submit()" >Set unavailable</button>
                      @else
                      <button type="button" class="btn btn-success my-3" onclick="document.querySelector('#form{{ $vehicule->plateNb }}').submit()"  >Set available</button>
                      @endif
                      @break
                      @else
                        @continue
                        @endif
                      @endif
                      
                    @endforeach
                    <form action="{{ route('secretary.updateState',$vehicule->plateNb) }}" id="form{{ $vehicule->plateNb }}" method="POST">@csrf</form>
                  </ul>
                </div>
                
              @endforeach
              <a href="{{ route('secretary.addVehicule') }}" style=" float: right;"class="btn btn-primary">Add a new vehicle</a>
          
          @else
            <p>You have no vehicles</p>
            <div>
              <a href="{{ route('secretary.addVehicule') }}" style=" float: right;"class="btn btn-primary">Add a new vehicle</a>
              </button>
              </div>
          @endif
        </div>
     </div>

 </div>
 @endsection
 @section('scripts')
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
</script>

@endsection
