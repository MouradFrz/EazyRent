@extends('layouts.workerLayout')
<link rel="stylesheet" href="{{ asset('css/garagist/index.css') }}">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g==" crossorigin="anonymous" referrerpolicy="no-referrer" />
@section('headTags')
    
@endsection
@section('content')
<div class="modal fade" id="condition" tabindex="-1" aria-labelledby="conditionModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel1">Update car condition and note: </h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
         <p>Chose a condition from the list below</p> 
         <form action="{{ route('garagist.setCondition',$vehicule->plateNb) }}" id="conditionForm" method="POST">@csrf
            <select name="condition" id="" class="form-control">
                <option value="Excellent">Excellent</option>
                <option value="Very good">Very good</option>
                <option value="Good">Good</option>
                <option value="Fair">Fair</option>
                <option value="Out of order">Out of order</option>
            </select>
            <label for="">Note</label>
            <textarea name="note"  class="form-control" style="height: 300px" placeholder="Leave a note for the secretaries and the agency owner in here"></textarea>
            </form>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            <button type="button" class="btn btn-success" onclick="document.querySelector('#conditionForm').submit()">Confirm</button>
            
          </div>
      </div>
    </div>
  </div>
<div>
<div class="container">
    @if (Session::get('message'))
    <div class="alert alert-success w-100 " role="alert">
        {{Session::get('message')}}
        </div>
    @endif
    @error('physicalState')
    {{ $message }}
    @enderror
    @error('note')
    {{ $message }}
    @enderror
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
                           
                        
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <p class="textmuted-pog">Price per Hour</p>
                        <p class="fs-14 fw-bold">{{ $vehicule->pricePerHour }} DZD</p>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <p class="textmuted-pog">Price Per day</p>
                        <p class="fs-14 fw-bold">{{ $vehicule->pricePerDay }} DZD</p>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <p class="textmuted-pog">Doors Number</p>
                        <p class="fs-14 fw-bold"></span>{{ $vehicule->doorsNb }}</p>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <p class="textmuted-pog">Horse Power</p>
                        <p class="fs-14 fw-bold"></span>{{ $vehicule->horsePower }}</p>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <p class="textmuted-pog">Air cooling</p>
                        <p class="fs-14 fw-bold"></span>{{ $vehicule->airCooling }}</p>
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
                                <hr>
                                <div class="d-flex justify-content-between mb-2">
                                    <p class="textmuted-pog">Condition</p>
                                    <p class="fs-14 fw-bold">{{ $vehicule->physicalState }}</p>
                                    
                                </div>
                                <div class="d-flex justify-content-between mb-2 flex-column">
                                    <p class="textmuted-pog d-block fw-bold">Note:</p>
                                    <p class="fs-14 ">{{ $vehicule->note }}</p>
                                    <button class="btn btn-primary "  data-bs-toggle="modal" data-bs-target="#condition">Update condition</button>
                                </div>
                            </div>
                        </div>
                    </div>
                   
                </div>
            </div>
        </div>
    </div>
</div>
<div class="container">
    <div class="reveiws">
        @foreach ($bookings as $booking)
        @if ($booking->state == "FINISHED")
        <div class="review w-100 d-flex ">
            <img src="{{ asset('images/users/faceIdImages/'. $booking->faceIdPath) }}" id="user-icon" alt="">
            <div class="d-flex flex-column ms-3">
                <p class="title">{{ $booking->firstName }} {{ $booking->lastName }}</p>
                <div class="rating">
                    @for($c=1;$c<=5;$c++) @if($booking->vehiculeRating >= $c)
                      <i class="fa-solid fa-star" style="color:darkorange;font-size:0.8rem;"></i>
                      @else
                      <i class="fa-solid fa-star" style="font-size:0.8rem;"></i>
                      @endif
                      @endfor
                      <span class="text-muted">{{$booking->vehiculeRating}}/5</span>
                </div>
                <div >
                    <p class="comment">{{ $booking->vehiculeComment }} Lorem ipsum dolor sit amet consectetur adipisicing elit. Iure ea soluta id ipsam libero voluptatem mollitia veniam recusandae voluptate temporibus quidem, aspernatur itaque reiciendis accusantium.</p>
                </div>
                <div>
                   <p class="text-muted date">{{ $booking->commentDate }}</p> 
                </div>
            </div>
        </div>
        @endif
        @endforeach
    </div>
</div>
</div>
@endsection