@extends('layouts.userLayout')
@section('content')
<div class="offer">
  <div class="container">
    <div class="offer_header">
      <h1>{{$vehicule->brand}}</h1>
      <h1>{{$vehicule->model}}</h1>
    </div>
    <div class="offer_media">
      {{-- <img src="{{asset('pubclic/images/vehicules'.$vehicule->imagePath)}}" alt=""> --}}
      <img src="{{asset('images/view-offers_hero.jpg')}}" alt="">
    </div>
    <div class="offer_details">
      <ul>
        <li>color: {{$vehicule->color}}</li>
        <li>type: {{$vehicule->type}}</li>
        <li>fuel: {{$vehicule->fuel}}</li>
        <li>year: {{$vehicule->year}}</li>
        <li>Gear type: {{$vehicule->gearType}}</li>
        <li>doors number: {{$vehicule->doorsNb}}</li>
        <li>Horse power: {{$vehicule->horsePower}}</li>
        <li>air cooling: {{$vehicule->airCooling}}</li>
        <li>Rating: {{$vehicule->rating}}</li>
      </ul>
    </div>
    <form action="">
      
    </form>
  </div>
</div>
@endsection
@section('script')
@endsection
