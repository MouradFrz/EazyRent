@extends('layouts.workerLayout')


@section('headTags')
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('css/admin/index.css') }}">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.12.0/css/jquery.dataTables.css">
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
          <h5 class="modal-title" id="exampleModalLabel">You are about to delete this garage </h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
         <p >Are you sure you want to delete this garage ? <br> <span style="color:red"> The garage manager that's currently managing this garage will be available for other garages of this branch. </span></p>
        </div>
        <div class="modal-footer">
            <button type="button" class="link link-secondary" data-bs-dismiss="modal">Close</button>
            <button type="button" class="link link-danger" onclick="document.querySelector('#deleteForm').submit()">Confirm</button>
            <form action="{{ route('owner.deleteGarage', $garage->garageID ) }}" id="deleteForm" method="POST">@csrf</form>
          </div>
      </div>
    </div>
  </div>
  <div class="modal fade" id="changeManager" tabindex="-1" aria-labelledby="changeManagerLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">You are about to change the manager for this garage.</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
         <p >Choose the new garage manager for this garage</p>
         <form action="{{ route('owner.changeManager') }}" id="changeForm" method="POST">@csrf
            <input type="text" style="display: none" name="garageID" value="{{ $garage->garageID }}">
                <select name="manager" id="managersList" class="form-control">
                    <option value="">Choose the new manager</option>
                    @foreach ($avGaragists as $e)
                        <option value="{{ $e->username }}">{{ $e->firstName }} {{ $e->lastName }}</option>
                    @endforeach
                </select>
        </form>
        </div>
        <div class="modal-footer">
            <button type="button" class="link link-secondary" data-bs-dismiss="modal">Close</button>
            <button type="button" class="link" onclick="document.querySelector('#changeForm').submit()">Confirm</button>
          </div>
      </div>
    </div>
  </div>
    <div>
        <div class="container">
            <h2 class="title">Garage details</h2>
            @if (Session::get('message'))
            <div class="alert alert-success w-100 alert-dismissible fade show" role="alert">
                {{ Session::get('message') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
              </div>
            @endif
            <div class="row">
            <div class="col-3">
                <p class="tag">Branch:</p>
                <p class="value">{{ $garage->region }}</p>
                <p class="tag">Address:</p>
                <p class="value">{{ $garage->address }}</p>
                <p class="tag">Id:</p>
                <p class="value">{{ $garage->garageID }}</p>
                <p class="tag">Cars count:</p>
                <p class="value">{{ count($cars) }}</p>
                <p class="tag">Capacity :</p>
                <p class="value">{{ $garage->capacity }}</p>

            </div>
            <div class="col-3">
                <p class="tag">Manager:</p>
                <p class="value">{{ $garagist->firstName }} {{ $garagist->lastName }}</p>
                @if(!is_null($garagist->phoneNumber))
                <p class="tag">Manager's phone number:</p>
                <p class="value">{{ $garagist->phoneNumber }} </p>
                @else
                <p class="tag">Manager's phone number:</p>
                <p class="value">Not available </p>
                @endif
            </div>
        </div>
            <p class="tag">Cars list:</p>
            <div class="mt-3">
                <table class="table table-striped " id="carlist">
                    <thead>
                    <tr>
                        <th>Plate number</th>
                        <th>Model</th>
                        <th>Make</th>
                        <th>Available</th>
                        <th>Car condition</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($cars as $element)
                    <tr>
                        <td>{{$element->plateNb}}</td>
                        <td scope="row">{{$element ->model}}</th>
                        <td>{{$element->brand}}</td>
                        <td>{{ $element->availablity }}</td>
                        <td>{{ $element->physicalState }}</td>
                    </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
              <button  class="link link-secondary" data-bs-toggle="modal" data-bs-target="#changeManager" >Change garage manager</button>
              <button type="button" class="link link-danger my-3"  data-bs-toggle="modal" data-bs-target="#exampleModal">
                Delete this garage
              </button>
        </div>
    </div>
@endsection


@section('scripts')
<script>
    let sectable = new DataTable('#carlist');
</script>
@endsection
