
@extends('layouts.workerLayout')
@section('headTags')
<link rel="stylesheet" href="{{ asset('css/app.css') }}">
{{-- <link rel="stylesheet" href="{{ asset('css/bootstrap.css') }}"> --}}
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
                <li>Vehicule: <span class="value">{{ $vehicule->model.$vehicule->brand }}</span></li>
                <li>Plate number: <span class="value">{{ $vehicule->plateNb }}</span></li>
                <li>Garage ID: <span class="value">{{ $vehicule->garageID }}</span></li>
              
            </ul>
        </div>
       
        @endforeach
         <button type="button" class="btn btn-primary"  data-bs-toggle="modal" data-bs-target="#exampleModal"></button>
     </div>
     @else
          <p>You have no vehicles</p>
          <button type="button" class="btn btn-primary"  data-bs-toggle="modal" data-bs-target="#exampleModal">
            Add a new Vehicle
          </button>
          @endif
     </div>
 </div>
 @endsection
