@extends('layouts.workerLayout')
@section('headTags')
<link rel="stylesheet" href="{{asset('css/secretary/index.css')}}">
@endsection
@section('content')
<script>
  let vehicles = document.querySelector('#vehicles')
  vehicles.classList.add('active')
</script>
<div class="add-vehicule mt-5">
  <div class="container">
    @if(Session::get('message'))
    <div class="alert alert-success w-100 " role="alert">
      {{Session::get('message')}}
    </div>
    @endif
    <h2>Add a vehicle</h2>
    <hr>
    <form method="POST" action="{{route('secretary.addVehiculePost')}}" enctype="multipart/form-data">
      @csrf
      <div class="row">
        <div class="col">
          <label for="category" class="form-label">Category</label>
          <select type="text" name="category" class="form-control">
            <option value="">Choose a category</option>
            <option value="Car">Car</option>
            <option value="Motorcycle">Motorcycle</option>
            <option value="Bus"> Bus or Mini-bus</option>
            <option value="Truck">Truck</option>
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
            <option value="Classic">Classic</option>
            <option value="Comfort">Comfort</option>
            <option value="Space">Space</option>
            <option value="Premium">Premium</option>
          </select>
          <span class="text-danger" style="font-size:0.8rem">
            @error('type')
            {{ $message }}
            @enderror
          </span>

        </div>
        <div class="col">
          <label for="brand" class="form-label">Brand</label>
          <Select name="brand" id="brand" class="form-control" onchange="loadModels()">
            <option value="">Select a brand</option>

          </Select>
          @error('brand')
          {{ $message }}
          @enderror
        </div>

      </div>
      <div class="row">
        <div class="col">
          <label for="model" class="form-label">Model</label>
          <Select name="model" id="model" class="form-control">
            <option value="">Choose a model</option>

          </Select>
          <span class="text-danger" style="font-size:0.8rem">
            @error('model')
            {{ $message }}
            @enderror
          </span>

        </div>
        <div class="col">
          <label for="year" class="form-label">Year</label>
          <input type="number" min="1970" max="2022" step="1" value="2022" name="year" class="form-control"
            placeholder="year">

        </div>

        <div class="col">
          <label for="color" class="form-label">Color</label>
          <select class="form-control" name="color" id="">
            <option value="">Any</option>
            <option value="Green">Green</option>
            <option value="Blue">Blue</option>
            <option value="Red">Red</option>
            <option value="Yellow">Yellow</option>
            <option value="Orange">Orange</option>
            <option value="White">White</option>
            <option value="Purple">Purple</option>
            <option value="Black">Black</option>
            <option value="Grey">Grey</option>
          </select>

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
          <input type="text" maxlength="10" name="plateNb" class="form-control" placeholder="Plate number"
            onkeypress="return isNumber(event)" value="{{ old('plateNb') }}">
          <span class="text-danger" style="font-size:0.8rem">
            @error('plateNb')
            {{ $message }}
            @enderror
          </span>

        </div>
        <div class="col">
          <label for="fuel" class="form-label">Fuel</label>
          <Select name="fuel" id="" class="form-control">
            <option value="">Choose a type of fuel</option>
            <option value="Sans-Plomb">Sans-plomb</option>
            <option value="Mazot">Mazot</option>
            <option value="Diesel">Diesel</option>
            <option value="Gaz">Gaz</option>
            <option value="Super">Super</option>
          </Select>
          <span class="text-danger" style="font-size:0.8rem">
            @error('fuel')
            {{ $message }}
            @enderror
          </span>

        </div>
        <div class="col">
          <label for="gearType" class="form-label">gear type</label>
          <Select name="gearType" id="" class="form-control">
            <option value="">Choose a type of gear</option>
            <option value="Manual">Manual</option>
            <option value="Mutomatic">Automatic</option>
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
          <Select name="doorsNb" id="" class="form-control">
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
          <input type="text" maxlength="4" name="horsePower" class="form-control" placeholder="Horse power"
            value="{{ old('horsePower') }}">
          <span class="text-danger" style="font-size:0.8rem">
            @error('horsePower')
            {{ $message }}
            @enderror
          </span>

        </div>

        <div class="col">
          <label for="airCooling" class="form-label">Air cooling</label>
          <input type="checkbox" name="airCooling" class="form-check-label" value="1" checked>

        </div>

      </div>
      <div class="row">
        <div class="col">
          <label for="pricePerHour" class="form-label">Price Per Hour (DZD)</label>
          <input type="text" name="pricePerHour" maxlength="4" class="form-control" placeholder="Price per hour"
            onkeypress="return isNumber(event)" value="{{ old('pricePerHour') }}">
          <span class="text-danger" style="font-size:0.8rem">
            @error('pricePerHour')
            {{ $message }}
            @enderror
          </span>

        </div>
        <div class="col">
          <label for="pricePerDay" class="form-label">Price Per Day (DZD)</label>
          <input type="text" name="pricePerDay" maxlength="4" class="form-control" placeholder="Price per day"
            onkeypress="return isNumber(event)" value="{{ old('pricePerDay') }}">
          <span class="text-danger" style="font-size:0.8rem">
            @error('pricePerDay')
            {{ $message }}
            @enderror
          </span>

        </div>
        <div class="col">
          <label for="physicalState" class="form-label">Physical state</label>
          <Select name="physicalState" id="" class="form-control">
            <option value="">Current vehicle state</option>
            <option value="mliha">mliha</option>
            <option value="ma mlihach">ma mlihach</option>
          </Select>
          <span class="text-danger" style="font-size:0.8rem">
            @error('physicalState')
            {{ $message }}
            @enderror
          </span>

        </div>

      </div>
      <div class="row">
        <div class="col-4">
          <label for="garageID" class="form-label">Garage</label>
          <Select name="garageID" id="" class="form-control">
            <option value="">Choose a garage</option>
            @foreach ($garages as $garage)
            <option value="{{ $garage->garageID }}">{{ $garage->address }}</option>
            @endforeach
          </Select>
          <span class="text-danger" style="font-size:0.8rem">
            @error('garageID')
            {{ $message }}
            @enderror
          </span>

        </div>
        <div class="col">
          <label for="imagePath" class="form-label">Vehicle Image</label>
          <input type="file" name="imagePath" id="" value="{{ old('imagePath') }} " style="width:100%">
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
  input {
    margin-bottom: 10px !important;
  }
</style>
@endsection

@section('scripts')

<script>
  let cars =
  [
  {
    "id": 0,
    "brand": "Dacia",
    "models": ["Logan", "Sandero", "Stepway", "Duster", "Lodgy"]
  },
  {
    "id": 1,
    "brand": "Renault",
    "models": [
      "Symbole",
      "Slio 4",
      "Kangoo",
      "Megan",
      "Fluence",
      "Kadjar",
      "Trafic"
    ]
  },
  {
    "id": 2,
    "brand": "Kia",
    "models": ["Picanto", "Rio", "Sportage", "Sorento"]
  },
  {
    "id": 3,
    "brand": "Hyundai",
    "models": [
      "i10",
      "i20",
      "i30",
      "i40",
      "i45",
      "Elantra",
      "Creta",
      "Tucson",
      "Santa fe",
      "i 40 crdi bva",
      "Accent",
    ]
  },
  {
    "id": 4,
    "brand": "Seat",
    "models": ["Ibiza", "Leon", "Arona", "Ateca","Toledo"]
  },
  {
    "id": 5,
    "brand": "Skoda",
    "models": ["Fabia", "Rapid", "Octavia","Scala","Superb","Yeti"]
  },
  {
    "id": 6,
    "brand": "Volkswagen",
    "models": [
      "Polo",
      "Caddy",
      "Golf 7",
      "Tiguan",
      "Amarok",
      "Passat",
      "Transporter",
      "Multivan",
      "Golf 8",
      "Golf 8 break"
    ]
  },
  {
    "id": 7,
    "brand": "Peugeot",
    "models": ["107","206","207", "207+", "208","306","307","308","406","407","Expert", "3008","Boxer","406"]
  },
  {
    "id": 8,
    "brand": "Mitsubishi",
    "models": ["Sportero"]
  },
  {
    "id": 9,
    "brand": "Infiniti",
    "models": ["q30"]
  },
  {
    "id": 10,
    "brand": "Audi",
    "models": ["a6","A1","A2","A3","A4","A5","A6","A7","A8"]
  },
  {
    "id": 11,
    "brand": "Mercedes-Benz",
    "models": ["Classe v", "Classe A","Classe G","Marco Polo","Classe M","Classe S","Viano"]
  },
  {
    "id": 12,
    "brand": "Porshe",
    "models": ["Classe A", "Classe A"]
  },
  {
    "id": 13,
    "brand": "Bmw",
    "models": ["Serie 02", "Serie 03", "x2 xdrive20d"]
  },
  {
    "id": 14,
    "brand": "Cherry",
    "models": ["QQ","M11","Karry","J1"]
  },
  {
    "id": 15,
    "brand": "Chevrolet",
    "models": ["Aveo","Apache","Beat","Beretta","Camaro","Cruze","El Camino","Swift","Master"]
  },
  {
    "id": 16,
    "brand": "Citroen",
    "models": ["Berlingo","C1","C2","C3","Camaro","Cruze","El Camino","Swift","Master"]
  },
  {
    "id": 17,
    "brand": "Ford",
    "models": ["Escape","Fiesta","Fiesta ST","Focus","Focus ST ","Focus RS","GT","Mustang"]
  },
  {
    "id": 18,
    "brand": "Jeep",
    "models": ["Commando","Compass","Liberty","Gladiator","Patriot","Renegade"]
  },
  {
    "id": 19,
    "brand": "Land Rover",
    "models": ["Range Rover","Evoque","Sport","Freelander","Series"]
  },
  {
    "id": 20,
    "brand": "Maruti",
    "models": ["Alto","1000","800"]
  },
  {
    "id": 21,
    "brand": "Mazda",
    "models": ["R100","1000","1300","R360"]
  },
  {
    "id": 22,
    "brand": "Nissan",
    "models": ["Micra","X Trail","Navara","Sunny","NT400"]
  }
]

   const brand = document.querySelector('#brand');
   const model = document.querySelector('#model');

   cars.forEach((e)=>{
    let option = document.createElement('option');
    option.value=e.brand;
    option.textContent=e.brand;
    brand.appendChild(option);
   });

   function loadModels(){
     let defOption = document.createElement('option');
     model.textContent=''
     defOption.value=''
     defOption.textContent="Choose a model"
     model.appendChild(defOption)
     cars.forEach((e)=>{
        if(e.brand==brand.value){
          e.models.forEach((el)=>{
            let option = document.createElement('option');
            option.value=el;
            option.textContent=el;
            model.appendChild(option);
          })
        }
     });
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
