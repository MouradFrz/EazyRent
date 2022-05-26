@extends('layouts.workerLayout')
@section('headTags')
<link rel="stylesheet" href="{{ asset('css/app.css') }}">
<link rel="stylesheet" href="{{ asset('css/bootstrap.css') }}">
<link rel="stylesheet" href="{{ asset('css/secretary/index.css') }}">
@endsection
@section('content')
@if (Session::get('alert'))
    
{{  Session::get('alert')}}
    
@endif
@if (Session::get('message'))
    
{{  Session::get('message')}}
    
@endif
<!-- Button trigger modal -->
<div class="modal fade" id="transferModal" tabindex="-1" aria-labelledby="transferModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel1">You are about to transfer this vehicule to another garage </h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
         <p>Chose the garage you want to transfer the vehicule to</p> 
         <form action="{{ route('secretary.transferVehicle',$vehicule->plateNb) }}" id="transferForm" method="POST">@csrf
            <select name="garageID" id="" class="form-control">
                @foreach ($garages as $garage)
                @if ($garage->garageID!=$vehicule->garageID)
                <option value="{{ $garage->garageID }}"> {{ $garage->address }}</option>
                @endif
                    
                @endforeach
            </select>
            </form>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            <button type="button" class="btn btn-danger" onclick="document.querySelector('#transferForm').submit()">Confirm</button>
            
          </div>
      </div>
    </div>
  </div>
<div class="modal fade" id="exampleModal1" tabindex="-1" aria-labelledby="exampleModalLabel1" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel1">You are about to delete this vehicle </h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
         <p>Are you sure you want to delete this vehicle ? </p> 
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            <button type="button" class="btn btn-danger" onclick="document.querySelector('#form').submit()">Confirm</button>
            <form action="{{ route('secretary.deleteVehicule',$vehicule->plateNb) }}" id="form" method="POST">@csrf</form>
          </div>
      </div>
    </div>
  </div>
  <div class="modal fade" id="exampleModal2" tabindex="-1" aria-labelledby="exampleModalLabel2" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel2">Change vehicle state </h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <p>Are you sure u want to change vehicule state?</p>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            <button type="button" class="btn btn-danger" onclick="document.querySelector('#form1').submit()">Confirm</button>
            <form action="{{ route('secretary.updateState',$vehicule->plateNb) }}" id="form1" method="POST">@csrf</form>
          </div>
      </div>
    </div>
  </div>
<div class="container">
    
    <div class="row m-0">
        <div class="col-lg-7 pb-5 pe-lg-5">
            <div class="row">
                <div class="col-12 p-5">
                    <img src="{{asset('images/vehicules/imagePaths/'.$vehicule->imagePath  )}}" alt="" style="width: 100%">
                </div>
                <div class="row m-0 bg-light">
                    <div class="col-md-4 col-6 ps-30 pe-0 my-4">
                        <p class="text-muted-pog">Category</p>
                        <p class="h5" ><span class="ps-1">{{ $vehicule->category }}</span></p>
                    </div>
                    <div class="col-md-4 col-6  ps-30 my-4">
                        <p class="text-muted-pog">Type</p>
                        <p class="h5 m-0">{{ $vehicule->type }}</p>
                    </div>
                    <div class="col-md-4 col-6 ps-30 my-4">
                        <p class="text-muted-pog">Year</p>
                        <p class="h5 m-0">{{ $vehicule->year }}</p>
                    </div>
                    <div class="col-md-4 col-6 ps-30 my-4">
                        <p class="text-muted-pog">Gear Type</p>
                        <p class="h5 m-0">{{ $vehicule->gearType }}</p>
                    </div>
                    <div class="col-md-4 col-6 ps-30 my-4">
                        <p class="text-muted-pog">Color</p>
                        <p class="h5 m-0">{{ $vehicule->color }}</p>
                    </div>
                    <div class="col-md-4 col-6 ps-30 my-4">
                        <p class="text-muted-pog">Fuel</p>
                        <p class="h5 m-0">{{ $vehicule->fuel }}</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-5 p-0 ps-lg-4">
            <div class="row m-0">
                <div class="col-12 px-4">
                    <div class="d-flex align-items-end mt-4 mb-2">
                        <p class="h4 m-0"><span class="pe-1">{{ $vehicule->model }}</span><span class="pe-1">{{ $vehicule->brand }}</span>
                        <p class="h4 m-0"><span class="pe-1">{{ $vehicule->availability }}</span>    
                        
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <p class="textmuted-pog">Price per Hour</p>
                        <p class="fs-14 fw-bold">{{ $vehicule->pricePerHour }}</p>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <p class="textmuted-pog">Price Per day</p>
                        <p class="fs-14 fw-bold"><span class="fas fa-dollar-sign pe-1"></span>{{ $vehicule->pricePerDay }}</p>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <p class="textmuted-pog">Doors Number</p>
                        <p class="fs-14 fw-bold"><span class="fas fa-dollar-sign pe-1"></span>{{ $vehicule->doorsNb }}</p>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <p class="textmuted-pog">Horse Power</p>
                        <p class="fs-14 fw-bold"><span class="fas fa-dollar-sign pe-1"></span>{{ $vehicule->horsePower }}</p>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <p class="textmuted-pog">Air cooling</p>
                        <p class="fs-14 fw-bold"><span class="fas fa-dollar-sign pe-1"></span>{{ $vehicule->airCooling }}</p>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <p class="textmuted-pog">Physical State</p>
                        <p class="fs-14 fw-bold"><span class="fas fa-dollar-sign pe-1"></span>
                            {{ $vehicule->physicalState }}</p>
                    </div>
                 
                    
                </div>
                <div class="col-12 px-0">
                    <div class="row bg-light m-0">
                        <div class="col-12 px-4 my-4">
                            <p class="fw-bold">More Details</p>
                        </div>
                        <div class="col-12 px-4">
                            <div class="d-flex  mb-4">
                                <span class="">
                                    <p class="text-muted">Plate Number</p>
                                    <input class="form-control" type="text" value="{{ $vehicule->plateNb }}"
                                        placeholder="1234 5678 9012 3456" disabled>
                                </span>
                                <div class=" w-100 d-flex flex-column align-items-end">
                                </div>
                            </div>
                            <div class="d-flex mb-5">
                                <span class="me-5">
                                    <p class="text-muted">Added By</p>
                                    <input class="form-control" type="text" value="{{ $vehicule->addedBy }}"
                                        placeholder="Name" disabled>
                                </span>
                                
                            </div>
                            <div class="d-flex flex-column">
                                @if (!is_null($latestBooking))
                                    
                                
                                    @if ($latestBooking->state=='REQUESTED' || $latestBooking->state=='ACCEPTED' || $latestBooking->state=='SIGNED' || $latestBooking->state=='ON GOING')
                                        
                                        @if ($vehicule->availability)
                                        <button type="button" class="btn btn-warning my-3" disabled data-bs-toggle="modal" data-bs-target="#exampleModal2">Set unavailable</button>
                                        @else
                                        <button type="button" class="btn btn-success my-3" disabled data-bs-toggle="modal" data-bs-target="#exampleModal2">Set available</button>
                                        @endif

                                    @else
                                        @if ($vehicule->availability)
                                        <button type="button" class="btn btn-warning my-3"  data-bs-toggle="modal" data-bs-target="#exampleModal2">Set unavailable</button>
                                        @else
                                        <button type="button" class="btn btn-success my-3"  data-bs-toggle="modal" data-bs-target="#exampleModal2">Set available</button>
                                        @endif

                                    @endif
                                @else
                                         @if ($vehicule->availability)
                                        <button type="button" class="btn btn-warning my-3"  data-bs-toggle="modal" data-bs-target="#exampleModal2">Set unavailable</button>
                                        @else
                                        <button type="button" class="btn btn-success my-3"  data-bs-toggle="modal" data-bs-target="#exampleModal2">Set available</button>
                                        @endif
                                @endif
                            <button type="button" class="btn btn-warning my-3"  data-bs-toggle="modal" data-bs-target="#transferModal"> Transfer to another garage</button>
                            <button type="button" class="btn btn-danger my-3"  data-bs-toggle="modal" data-bs-target="#exampleModal1"> Delete this vehicle</button>
                            </div>
                        </div>
                    </div>
                   
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal -->

@endsection
@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
@endsection