@extends('layouts.workerLayout')
@section('content')
    
    {{-- <form action="{{ route('owner.addEmployeePost') }}" method="POST" class="container-fluid">
        @csrf
        <div class="row">
            <div class="col-2">


            </div>
        
        <input type="text" name="username" id="" class="form-control" placeholder="username">
        <input type="text" name="password" id="" class="form-control" placeholder="pw">
        <input type="text" name="firstName" id="" class="form-control" placeholder="firstName">
        <input type="text" name="lastName" id="" class="form-control" placeholder="lastName">
        <input type="email" name="email" id="" class="form-control" placeholder="email">
        <input type="text" name="address" id="" class="form-control" placeholder="address">
        <input type="date" name="birthDate" id="" class="form-control" placeholder="birth date">

        <button type="submit" class="btn btn-success">Save</button>
    </div>
    </form> --}}
    
    <div class="create-agency mt-5">
        <div class="container">
          <h2>Add Car</h2>
          <hr>
          <form method="POST" action="{{route('secretary.addVehiculePost')}}" enctype="multipart/form-data">
            @csrf
            <div class="row">
              <div class="col">
                <label for="plateNb" class="form-label">Plate Number</label>
                <input type="text" name="plateNb" class="form-control" placeholder="Plate number"  >
              
              </div>
              <div class="col">
                <label for="brand" class="form-label">Brand</label>
                <input name="brand" id="" class="form-control" placeholder="Brand">

            </div>
            <div class="col">
              <label for="model" class="form-label">Model</label>
              <input name="model" id="" class="form-control" placeholder="Model">

          </div>
            </div>
            <div class="row">
                <div class="col">
                    <label for="type" class="form-label">Type</label>
                    <input type="text" name="type" class="form-control" placeholder="Type"  >
                   
                </div>
                <div class="col">
                    <label for="color" class="form-label">Color</label>
                    <input type="text" name="color" class="form-control" placeholder="Color">
                 
                  </div>
                  <div class="col">
                  <label for="year" class="form-label">year</label>
                  <input type="text" name="year" class="form-control" placeholder="year">
               
                </div>
            </div>
          <div class="row">
            <div class="col">
                <label for="fuel" class="form-label">fuel</label>
                <input type="text" name="fuel" class="form-control" placeholder="fuel"  >
               
            </div>
            <div class="col">
                <label for="gearType" class="form-label">gear type</label>
                <input type="text" name="gearType" class="form-control" placeholder="gear type">
             
              </div>
              <div class="col">
                <label for="doorsNb" class="form-label">Doors number</label>
                <input type="text" name="doorsNb" class="form-control" placeholder="Doors number">
             
              </div>
        </div>
        <div class="row">
          <div class="col">
              <label for="horsePower" class="form-label">Horse power</label>
              <input type="text" name="horsePower" class="form-control" placeholder="Horse power"  >
             
          </div>
          
            <div class="col">
              <label for="physicalState" class="form-label">Physical state</label>
              <input type="text" name="physicalState" class="form-control" placeholder="Physical state">
           
            </div>
            <div class="col">
              <label for="airCooling" class="form-label">Air cooling</label>
              <input type="checkbox" name="airCooling"  class="form-check-label" >
           
            </div>
      </div>
      <div class="row">
        <div class="col">
            <label for="category" class="form-label">Category</label>
            <input type="text" name="category" class="form-control" placeholder="Category"  >
           
        </div>
        
          <div class="col">
            <label for="pricePerHour" class="form-label">Price Per Hour</label>
            <input type="text" name="pricePerHour" class="form-control" placeholder="Price per hour">
         
          </div>
          <div class="col">
            <label for="pricePerDay" class="form-label">Price Per Day</label>
            <input type="text" name="pricePerDay"  class="form-control" placeholder="Price per day" >
         
          </div>
    </div><div class="row">
      <div class="col">
          <label for="garageID" class="form-label">Garage</label>
          <input type="text" name="garageID" class="form-control" placeholder="Garage"  >
         
      </div>
      <input type="file" name="imagePath" id="">
  </div>
      
                   <button type="submit" class="btn btn-primary">Add Vehicule</button>

            
          </form>
        </div>
      </div>
@endsection

@section('headTags')
<title>Add a new vehicule</title>
<link rel="stylesheet" href="{{ asset('css/app.css') }}">
<style>
    input{
        margin-bottom: 10px !important;
    }
</style>
@endsection