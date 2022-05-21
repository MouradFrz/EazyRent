@extends('layouts.workerLayout')
@section('content')
  
@if(Session::get('message'))
{{Session::get('message')}}
@endif

    <div class="add-vehicule mt-5">
        <div class="container">
          <h2>Add Car</h2>
          <hr>
          <form method="POST" action="{{route('secretary.addVehiculePost')}}" enctype="multipart/form-data">
            @csrf
            <div class="row">
              <div class="col">
                <label for="category" class="form-label">Category</label>
                <select type="text" name="category" class="form-control">
                  <option value="">Choose a category</option>
                  <option value="car">Car</option>
                  <option value="motorcycle">Motorcycle</option>
                  <option value="bus"> Bus or Mini-bus</option>
                  <option value="truck">Truck</option>
          
                </select>
                <span class="text-danger" style="font-size:0.8rem">
                  @error('category')
                    {{ $message }}
                  @enderror
                </span>
  
            </div>
            <div class="col">
              <label for="type" class="form-label">Type</label>
              <select type="text" name="type" class="form-control">
              <option value="">Choose a type</option>
                  <option value="classic">Classic</option>
                  <option value="comfort">Comfort</option>
                  <option value="Space">Space</option>
                  <option value="premium">Premium</option>
                 
                </select>
                <span class="text-danger" style="font-size:0.8rem">
                  @error('type')
                    {{ $message }}
                  @enderror
                </span>
  
          </div>
              <div class="col">
                <label for="brand" class="form-label">Brand</label>
                <Select name="brand" id="" class="form-control" >
                  <option value="">Choose a brand</option>
                  <option value="markaA">A</option>
                  <option value="markaB">B</option>
                  <option value="markaC">C</option>
                </Select>
                @error('brand')
                {{ $message }}
            @enderror
            </div>
            
            </div>
            <div class="row">
              <div class="col">
                <label for="model" class="form-label">Model</label>
                <Select name="model" id="" class="form-control" >
                  <option value="">Choose a model</option>
                  <option value="modelA">A</option>
                  <option value="modelB">B</option>
                  <option value="modelC">C</option>
                </Select>
                <span class="text-danger" style="font-size:0.8rem">
                  @error('model')
                    {{ $message }}
                  @enderror
                </span>
  
            </div>
                <div class="col">
                  <label for="year" class="form-label">year</label>
                  <input type="number" min="1970" max="2022" step="1" value="2022"name="year" class="form-control" placeholder="year">
            
                </div>
                
                <div class="col">
                    <label for="color" class="form-label">Color</label>
                    <input type="text" name="color" class="form-control" placeholder="Color" value="{{ old('color') }}">
                    <span class="text-danger" style="font-size:0.8rem">
                      @error('color')
                        {{ $message }}
                      @enderror
                    </span>
      
                  </div>
                  
            </div>
          <div class="row">
            <div class="col">
              <label for="plateNb" class="form-label">Plate Number</label>
              <input type="text" maxlength="10" name="plateNb" class="form-control" placeholder="Plate number" value="{{ old('plateNb') }}" >
              <span class="text-danger" style="font-size:0.8rem">
                @error('plateNb')
                  {{ $message }}
                @enderror
              </span>

            </div>
            <div class="col">
                <label for="fuel" class="form-label">fuel</label>
                <Select name="fuel" id="" class="form-control" >
                  <option value="">Choose a type of fuel</option>
                  <option value="sansPlomb">Sans-plomb</option>
                  <option value="mazot">Mazot</option>
                  <option value="diesel">Diesel</option>
                  <option value="gaz">Gaz</option>
                  <option value="super">Super</option>
                </Select>
                <span class="text-danger" style="font-size:0.8rem">
                  @error('fuel')
                    {{ $message }}
                  @enderror
                </span>
  
            </div>
            <div class="col">
                <label for="gearType" class="form-label">gear type</label>
                <Select name="gearType" id="" class="form-control" >
                  <option value="">Choose a type of gear</option>
                  <option value="manual">Manual</option>
                  <option value="automatic">Automatic</option>
                </Select>
                <span class="text-danger" style="font-size:0.8rem">
                  @error('gearType')
                    {{ $message }}
                  @enderror
                </span>
  
              </div>
             
        </div>
        <div class="row">
           <div class="col">
                <label for="doorsNb" class="form-label">Doors number</label>
                <Select name="doorsNb" id="" class="form-control" >
                  <option value="">Choose the number of doors</option>
                  <option value="2">2</option>
                  <option value="4">4</option>
                </Select>
                <span class="text-danger" style="font-size:0.8rem">
                  @error('doorsNb')
                    {{ $message }}
                  @enderror
                </span>
  
              </div>
          <div class="col">
              <label for="horsePower" class="form-label">Horse power</label>
              <input type="text" maxlength="4" name="horsePower" class="form-control" placeholder="Horse power" value="{{ old('horsePower') }}" >
              <span class="text-danger" style="font-size:0.8rem">
                @error('horsePower')
                  {{ $message }}
                @enderror
              </span>

          </div>
          
            <div class="col">
            <label for="airCooling" class="form-label">Air cooling</label>
            <input type="checkbox" name="airCooling"  class="form-check-label" value="1" checked>
         
          </div>
           
      </div>
      <div class="row">  
          <div class="col">
            <label for="pricePerHour" class="form-label">Price Per Hour</label>
            <input type="text" name="pricePerHour" class="form-control" placeholder="Price per hour" value="{{ old('pricePerHour') }}">
            <span class="text-danger" style="font-size:0.8rem">
              @error('pricePerHour')
                {{ $message }}
              @enderror
            </span>

          </div>
          <div class="col">
            <label for="pricePerDay" class="form-label">Price Per Day</label>
            <input type="text" name="pricePerDay"  class="form-control" placeholder="Price per day" value="{{ old('pricePerDay') }}">
            <span class="text-danger" style="font-size:0.8rem">
              @error('pricePerDay')
                {{ $message }}
              @enderror
            </span>

          </div>
          <div class="col">
            <label for="physicalState" class="form-label">Physical state</label>
            <Select name="physicalState" id="" class="form-control" >
              <option value="">Current vehicle state</option>
              <option value="classic">mliha</option>
              <option value="classic">ma mlihach</option>
            </Select>
            <span class="text-danger" style="font-size:0.8rem">
              @error('physicalState')
                {{ $message }}
              @enderror
            </span>

          </div>
         
    </div><div class="row">
      <div class="col-4">
          <label for="garageID" class="form-label">Garage</label>
          <Select name="garageID" id="" class="form-control" >
            <option value="">Choose a garage</option>
            <option value="3">3</option>
            <option value="4">4</option>
          </Select>
          <span class="text-danger" style="font-size:0.8rem">
            @error('garageID')
              {{ $message }}
            @enderror
          </span>

      </div>
      <div class="col">
        <label for="imagePath" class="form-label">Car Image</label>
         <input type="file" name="imagePath" id="" value="{{ old('imagePath') }} "style="width:100%">
         <span class="text-danger" style="font-size:0.8rem">
          @error('imagePath')
            {{ $message }}
          @enderror
        </span>

      </div>
     
  </div>
      
                   <button type="submit" class="btn my-3 btn-primary">Add Vehicule</button>

            
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