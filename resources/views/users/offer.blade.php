@extends('layouts.userLayout')
@section('content')
<div class="offer">
  <div class="container">
    <div class="offer_header">
      <h1>{{$vehicule->brand}} {{$vehicule->model}}</h1>
    </div>
    <div class="row">
      <div class="offer_media col-8">
        {{-- <img src="{{asset('pubclic/images/vehicules'.$vehicule->imagePath)}}" alt=""> --}}
        <img src="{{asset('images/vehicules/imagePaths/'.$vehicule->imagePath)}}" alt="">
      </div>
      <div class="offer_details col-4">
        <table class="table table-striped">
          <tbody>
            <tr>
              <th scope="row">color : </th>
              <td>{{$vehicule->color}}</td>
            </tr>
            <tr>
              <th scope="row">type : </th>
              <td>{{$vehicule->type}}</td>
            </tr>
            <tr>
              <th scope="row">fuel : </th>
              <td>{{$vehicule->fuel}}</td>
            </tr>
            <tr>
              <th scope="row">year : </th>
              <td>{{$vehicule->year}}</td>
            </tr>
            <tr>
              <th scope="row">gear type : </th>
              <td>{{$vehicule->gearType}}</td>
            </tr>
            <tr>
              <th scope="row">doors number : </th>
              <td>{{$vehicule->doorsNb}}</td>
            </tr>
            <tr>
              <th scope="row">horse power : </th>
              <td>{{$vehicule->horsePower}}</td>
            </tr>
            <tr>
              <th scope="row">air cooling : </th>
              <td>{{$vehicule->airCooling}}</td>
            </tr>
            <tr>
              <th scope="row">rating : </th>
              <td>{{$vehicule->rating}}</td>
            </tr>
          </tbody>
        </table>
        {{-- <ul>
          <li>type: {{$vehicule->type}}</li>
          <li>fuel: {{$vehicule->fuel}}</li>
          <li>year: {{$vehicule->year}}</li>
          <li>Gear type: {{$vehicule->gearType}}</li>
          <li>doors number: {{$vehicule->doorsNb}}</li>
          <li>Horse power: {{$vehicule->horsePower}}</li>
          <li>air cooling: {{$vehicule->airCooling}}</li>
          <li>Rating: {{$vehicule->rating}}</li>
        </ul> --}}
      </div>
    </div>
  </div>
</div>
@endsection
@section('script')
@endsection
