@extends('layouts.workerLayout')
@section('headTags')
<title>Add Agency</title>
<link rel="stylesheet" href="{{ asset('css/owner/index.css') }}" @section('content') @if (Auth::user()->agencyID)
<p>there's a probleme you should not be able to see this view</p>
@else
<div class="create-agency" style="min-height: 80vh">
  <div class="container">
    <h2 class="title">add agency</h2>
    <hr>
    <form method="POST" action="{{route('owner.createAgencyPost')}}" enctype="multipart/form-data">
      @csrf
      <div class="row">
        <div class="col">
          <label for="owner username" class="form-label">Owner</label>
          <input type="text" name="ownerUsername" class="form-control" placeholder="{{Auth::user()->username}}"
            aria-label="Owner" disabled>
        </div>
        <div class="col">
          <label for="agency name" class="form-label">Agency name</label>
          <input type="text" name="agencyName" class="form-control" placeholder="Agency name" aria-label="Agency name">
          @error('agencyName')
          {{ $message }}
          @enderror
        </div>
      </div>
      <div class="row">
        <div class="col">
          <label for="commercial register number" class="form-label">commercial register number</label>
          <input type="text" name="commercialRegisterNb" class="form-control" placeholder=""
            aria-label="commercial register number">
          @error('commercialRegisterNb')
          {{ $message }}
          @enderror
        </div>
        <div class="col">
          <label for="date of registration" class="form-label">date of registration</label>
          <input type="date" name="registrationDate" class="form-control" placeholder="date of registration"
            aria-label="date of registration">
          @error('registrationDate')
          {{ $message }}
          @enderror
        </div>
      </div>
      <div class="row">
        <div class="col">
          <label for="agency creation year" class="form-label">agency creation year</label>
          <input type="number" max="2099" step="1" value="2022" name="agencyCreationYear" class="form-control"
            placeholder="" aria-label="agency creation date">
          @error('agencyCreationYear')
          {{ $message }}
          @enderror
        </div>
        <div class="col">
          <label for="password" class="form-label">password</label>
          <input type="password" name="password" class="form-control" placeholder="" aria-label="password">
          @error('password')
          {{ $message }}
          @enderror
        </div>
      </div>
      <div class="row">
        <div class="col-6">
          <label for="logo" class="form-label">Insert an image of your agency's logo</label>
          <input type="file" accept="image/png, image/jpeg" name="logo" class="form-control">
          @error('logo')
          {{ $message }}
          @enderror
        </div>
      </div>
      <button type="submit" class="btn btn-primary">add agency</button>
    </form>
  </div>
</div>
@endif

@endsection
