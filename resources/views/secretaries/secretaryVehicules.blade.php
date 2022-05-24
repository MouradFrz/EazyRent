
@extends('layouts.workerLayout')
@section('headTags')
<link rel="stylesheet" href="{{ asset('css/app.css') }}">
<link rel="stylesheet" href="{{ asset('css/owner/index.css') }}">
@endsection
 @section('content')

 
 <div class="py-4">
     <div class="container">
        <h2>Vehicles list</h2>
         <div class="cards">
          @if (count($vehicules)!=0)
             @foreach ($vehicules as $vehicule)
                <div class="card-custom">
                  <ul>
                    <li>Vehicule: <span class="value">{{$vehicule->brand}} {{ $vehicule->model }}</span></li>
                    <li>Plate number: <span class="value">{{ $vehicule->plateNb }}</span></li>
                    <li>Garage ID: <span class="value">{{ $vehicule->garageID }}</span></li>
                    <li><a href="{{ route('secretary.vehiculeDetails', $vehicule->plateNb) }}">View more</a></span></li>
                    
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
