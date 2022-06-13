@extends('layouts.workerLayout')
@section('headTags')
<link rel="stylesheet" href="{{ asset('css/owner/index.css') }}">
<link rel="stylesheet" href="{{ asset('css/app.css') }}">
@endsection


@section('content')
<script>
  let garages = document.querySelector('#garages')
  garages.classList.add('active')
</script>
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Create a garage </h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form action="{{ route('owner.addGarage') }}" method="POST" id="form">
          @csrf
          <label for="">Address</label>
          <input type="text" class="form-control" name="address">
          <label for="">Capacity</label>
          <input type="text" class="form-control" name="capacity" onkeypress="return isNumber(event)" maxlength="3">
          <label for="">Branche </label>
          <select name="branche" class="form-control" id="branchList" onchange="fillBranches()">
            <option value="">Choose a branch</option>
          </select>
          <label for="">Manager </label>
          <select name="manager" class="form-control" id="managersList">
            <option value="">Choose a manager</option>
          </select>

        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="link link-secondary" data-bs-dismiss="modal">Close</button>
        <button type="button" class="link" onclick="document.querySelector('#form').submit()">Confirm</button>
      </div>
    </div>
  </div>
</div>
<div style="min-height: 80vh">
  <div class="container">

    <h2 class="title">Garages management</h2>
    <hr>
    @if (Session::get('message'))
    <div class="alert alert-danger w-100 alert-dismissible fade show" role="alert">
      {{ Session::get('message') }}
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif
    @if (Session::get('success'))
    <div class="alert alert-success w-100 alert-dismissible fade show" role="alert">
      {{ Session::get('success') }}
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif
    @error('address')
    <div class="alert alert-danger w-100 alert-dismissible fade show" role="alert">
      {{ $message }}
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @enderror
    @error('manager')
    <div class="alert alert-danger w-100 alert-dismissible fade show" role="alert">
      {{ $message }}
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @enderror
    @error('branche')
    <div class="alert alert-danger w-100 alert-dismissible fade show" role="alert">
      {{ $message }}
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @enderror
    @error('capacity')
    <div class="alert alert-danger w-100 alert-dismissible fade show" role="alert">
      {{ $message }}
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @enderror
    <div class="cards">
      @if (count($garages)!=0)
      @foreach ($garages as $garage )
      <div class="card-custom">
        <ul>
          <li>Garage id : <span class="value">{{ $garage->garageID }}</span></li>
          <li>Branch: <span class="value">{{ $garage->region }}</span></li>
          <li>Address: <span class="value">{{ $garage->address }}</span></li>
          <li>Total capacity: <span class="value">{{ $garage->capacity }}</span></li>
          <li>Empty spots: <span class="value">{{ $garage->capacity - $garage->vehiculesNb }}</span></li>
          <li>Manager: <span class="value">{{ $garage->firstName}} {{ $garage->lastName }}</span></li>
          <li><a href="{{ route('owner.garageDetails',$garage->garageID) }}">View more</a></li>
        </ul>
      </div>
      @endforeach

      <button type="button" class="btn btn-primary" style="min-height:150px" data-bs-toggle="modal"
        data-bs-target="#exampleModal" onclick="fillForm()">
        Add a new garage
      </button>
      @else
      <p>You have no garages!</p>
      <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal"
        onclick="fillForm()">
        Add a new garage
      </button>
      @endif
    </div>
  </div>



</div>
@endsection

@section('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.js"
  integrity="sha512-n/4gHW3atM3QqRcbCn6ewmpxcLAHGaDjpEBu4xZd47N0W2oQ+6q7oc3PXstrJYXcbNU1OHdQ1T7pAP+gi5Yu8g=="
  crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script>
  function fillForm(e){
      $.get(`loadForm`,function(data){
        let list = document.querySelector('#branchList')
        list.innerText=''   ;
        let x = document.createElement('option')
        x.value=""
        x.innerText="Choose a branch"
        list.appendChild(x);
        data[0].forEach((e)=>{
          const element = document.createElement("option");
          element.value=e.brancheID;
          element.innerText=e.region;
          list.appendChild(element);
        });
      })
    }
    function fillBranches(e){
        if(document.querySelector('#branchList').value != false){
      $.get(`availableGaragists/${document.querySelector('#branchList').value}`,function(data){
        let list = document.querySelector('#managersList')
        list.innerText='' ;
        let x = document.createElement('option')
        x.value=""
        x.innerText="Choose a manager"

        data.forEach((e)=>{
          const element = document.createElement("option");
          element.value=e.username;
          element.innerText=`${e.firstName} ${e.lastName}`;
          list.appendChild(element);
        });
      })}else{
        let list = document.querySelector('#managersList')
        list.innerText=''   ;
        let x = document.createElement('option')
        x.value=""
        x.innerText="Choose a manager"
        list.appendChild(x);
      }
    }
    function isNumber(evt) {
          evt = (evt) ? evt : window.event;
          var charCode = (evt.which) ? evt.which : evt.keyCode;
            if (charCode > 31 && (charCode < 48 || charCode > 57)) {
              return false;
            }
    return true;
}
</script>

@endsection
