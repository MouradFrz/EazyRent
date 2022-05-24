@extends('layouts.workerLayout')
@section('headTags')
<link rel="stylesheet" href="{{ asset('css/app.css') }}">
{{-- <link rel="stylesheet" href="{{ asset('css/bootstrap.css') }}"> --}}
<link rel="stylesheet" href="{{ asset('css/secretary/index.css') }}">
@endsection
@section('content')
<!-- Button trigger modal -->
<div class="container">
    <div class="row m-0">
        <div class="col-lg-7 pb-5 pe-lg-5">
            <div class="row">
                <div class="col-12 p-5">
                    <img src="{{ $vehicule->imagePath }}"
                        alt="">
                </div>
                <div class="row m-0 bg-light">
                    <div class="col-md-4 col-6 ps-30 pe-0 my-4">
                        <p class="text-muted">Category</p>
                        <p class="h5" ><span class="ps-1">{{ $vehicule->category }}</span></p>
                    </div>
                    <div class="col-md-4 col-6  ps-30 my-4">
                        <p class="text-muted">Type</p>
                        <p class="h5 m-0">{{ $vehicule->type }}</p>
                    </div>
                    <div class="col-md-4 col-6 ps-30 my-4">
                        <p class="text-muted">Year</p>
                        <p class="h5 m-0">{{ $vehicule->year }}</p>
                    </div>
                    <div class="col-md-4 col-6 ps-30 my-4">
                        <p class="text-muted">Gear Type</p>
                        <p class="h5 m-0">{{ $vehicule->gearType }}</p>
                    </div>
                    <div class="col-md-4 col-6 ps-30 my-4">
                        <p class="text-muted">Color</p>
                        <p class="h5 m-0">{{ $vehicule->color }}</p>
                    </div>
                    <div class="col-md-4 col-6 ps-30 my-4">
                        <p class="text-muted">Fuel</p>
                        <p class="h5 m-0">{{ $vehicule->fuel }}</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-5 p-0 ps-lg-4">
            <div class="row m-0">
                <div class="col-12 px-4">
                    <div class="d-flex align-items-end mt-4 mb-2">
                        <p class="h4 m-0"><span class="pe-1">{{ $vehicule->model }}</span><span class="pe-1">{{ $vehicule->brand }}</span><span
                                class="pe-1">B</span></p>
                        
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <p class="textmuted">Price per Hour</p>
                        <p class="fs-14 fw-bold">{{ $vehicule->pricePerHour }}</p>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <p class="textmuted">Price Per day</p>
                        <p class="fs-14 fw-bold"><span class="fas fa-dollar-sign pe-1"></span>{{ $vehicule->pricePerDay }}</p>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <p class="textmuted">Doors Number</p>
                        <p class="fs-14 fw-bold"><span class="fas fa-dollar-sign pe-1"></span>{{ $vehicule->doorsNb }}</p>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <p class="textmuted">Horse Power</p>
                        <p class="fs-14 fw-bold"><span class="fas fa-dollar-sign pe-1"></span>{{ $vehicule->horsePower }}</p>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <p class="textmuted">Air cooling</p>
                        <p class="fs-14 fw-bold"><span class="fas fa-dollar-sign pe-1"></span>{{ $vehicule->airCooling }}</p>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <p class="textmuted">Physical State</p>
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
                                        placeholder="1234 5678 9012 3456">
                                </span>
                                <div class=" w-100 d-flex flex-column align-items-end">
                                </div>
                            </div>
                            <div class="d-flex mb-5">
                                <span class="me-5">
                                    <p class="text-muted">Added By</p>
                                    <input class="form-control" type="text" value="{{ $vehicule->addedBy }}"
                                        placeholder="Name">
                                </span>
                                
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