@extends('layouts.userLayout')
@section('head')
      
@endsection
@section('content')
    <div class="view-offers">
        <div class="view-offers_hero">
            <div class="container d-flex flex-column align-items-center">
                <div class="view-offers_hero_content">
                    <h1>view offers</h1>
                    <h2>choose the most appropriate car for you!</h2>
                </div>
            </div>
        </div>
        <div class="container">
            @if (count($vehicules) == 0)
                <p class="text-center">There is no available vehicles</p>
                <p class="text-center">Change search values or try later</p>
            @else
                <div class="row wrapper">
                    <div class="filter col-3">
                      <h3>Filter results</h3>
                      <form action="{{route('user.filterVehicules')}}" class="" method="GET">
                        <label for="">Brand</label>
                        <select class="inputs" name="make" id="brand" onchange="loadModels()">
                          <option value="">Any</option>

                        </select>
                        <label for="">Model</label>
                        <select class="inputs" name="model" id="model">
                          <option value="">Any</option>
                        </select>
                        <label for="">Type</label>
                        <select class="inputs" name="type" id="">
                          <option value="">Any</option>
                          <option value="Classic">Classic</option>
                          <option value="Comfort">Comfort</option>
                          <option value="Space">Space</option>
                          <option value="Premium">Premium</option>
                        </select>
                        <label for="">Category</label>
                        <select class="inputs" name="category" id="">
                          <option value="">Any</option>
                          <option value="Car">Car</option>
                          <option value="Motorcycle">Motorcycle</option>
                          <option value="Bus"> Bus or Mini-bus</option>
                          <option value="Truck">Truck</option>
                        </select>
                        <label for="">Color</label>
                        <select class="inputs" name="color" id="">
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
                        <label for="">Year</label>
                        <input type="text" max="2022" placeholder="2000" maxlength="4" name="year" class="inputs" onkeypress="return isNumber(event)">
                        <label for="">Gear type</label>
                        <select class="inputs" name="gear" id="">
                          <option value="">Any</option>
                          <option value="Manual">Manual</option>
                          <option value="Mutomatic">Automatic</option>
                        </select>
                        <label for="">Fuel</label>
                        <select class="inputs" name="fuel" id="">
                          <option value="">Any</option>
                          <option value="Sans-Plomb">Sans-plomb</option>
                          <option value="Mazot">Mazot</option>
                          <option value="Diesel">Diesel</option>
                          <option value="Gaz">Gaz</option>
                          <option value="Super">Super</option>
                        </select>
                        <label for="">Price per day</label>
                        <div class="row">
                          <input type="number" name="minDay" class="inputs col" placeholder="Minimum">
                          <input type="number" name="maxDay" class="inputs col" placeholder="Maximum">
                        </div>
                        <label for="">Price per hour</label>
                        <div class="row">
                          <input type="number" name="minHour" class="inputs col" placeholder="Minimum">
                          <input type="number" name="maxHour" class="inputs col" placeholder="Maximum">
                        </div>
                        
                        <button type="submit" class="custom-btn custom-btn-dark mt-3">Filter</button>
                      </form>
                    </div>
                    <div class="offers col">
                        @foreach ($vehicules as $vehicule)
                            <div class="minimized-offer row">
                                <div class="minimized-offer_media col-12 col-md-3">
                                    <img src="{{ asset('images/vehicules/imagePaths/' . $vehicule->imagePath) }}" alt="">
                                </div>
                                <div class="minimized-offer_content col-md-9">
                                    <div class="head d-flex justify-content-between">
                                        <div>
                                            <h2>{{ $vehicule->brand }} {{ $vehicule->model }}</h2>
                                        </div>
                                        <div class="price">
                                            <strong>
                                                @php
                                                    $diff = session('dropOffDate')->diff(session('pickUpDate'));
                                                    $days = $diff->days;
                                                    $hours = $diff->h;
                                                    $price = $vehicule->pricePerHour * $hours + $vehicule->pricePerDay * $days;
                                                    echo $price, ' dzd';
                                                @endphp
                                            </strong>
                                            <p>{{ $vehicule->pricePerDay }} dzd /day</p>
                                        </div>
                                    </div>
                                    <div class="prop">
                                        <ul
                                            class="list-group list-group-horizontal d-flex align-items-center justify-content-between">
                                            <li class="list-item "><i class="fa-solid fa-gas-pump"></i> Fuel :
                                                {{ $vehicule->fuel }} </li>
                                            <li class="list-item "><i class="fa-solid fa-gear"></i> Gear type :
                                                {{ $vehicule->gearType }} </li>
                                            <li class="list-item "><i class="fa-solid fa-door-closed"> </i> Doors number
                                                : {{ $vehicule->doorsNb }} </li>
                                            <li class="list-item "><i class="fa-solid fa-horse-head"></i> </i> Horse
                                                power : {{ $vehicule->horsePower }} </li>
                                            <li class="list-item "><i class="fa-solid fa-fan"></i></i> </i> Air cooling
                                                :
                                                @if ($vehicule->airCooling)
                                                    Available
                                                @else
                                                    Not available
                                                @endif
                                            </li>
                                        </ul>
                                    </div>
                                    <hr />
                                    <div class="d-flex justify-content-between">
                                        <div class="rating">
                                            @for ($c = 1; $c <= 5; $c++)
                                                @if ($vehicule->rating >= $c)
                                                    <i class="fa-solid fa-star"
                                                        style="color:darkorange;font-size:1rem;"></i>
                                                @else
                                                    <i class="fa-solid fa-star" style="font-size:1rem;"></i>
                                                @endif
                                            @endfor
                                            <span>{{ $vehicule->rating == null ? 'No ratings' : $vehicule->rating }}</span>
                                        </div>
                                        <a href="{{ route('user.viewOfferDetails', ['plateNb' => $vehicule->plateNb]) }}"
                                            class="custom-btn custom-btn-dark">View More
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
                <div>{{ $vehicules->links('pagination::bootstrap-5') }}</div>
            @endif
        </div>

    </div>
@endsection
@section('script')
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

   const loadModels = () => {
       let defOption = document.createElement('option');
       model.textContent = '';
       defOption.value = '';
       defOption.textContent = "Choose a model";
       model.appendChild(defOption);
       cars.forEach((e) => {
           if (e.brand == brand.value) {
               e.models.forEach((el) => {
                   let option = document.createElement('option');
                   option.value = el;
                   option.textContent = el;
                   model.appendChild(option);
               });
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