@extends('layouts.workerLayout')
@section('content')
    @if(Session::get('message'))
    <div class="alert alert-success w-100 " role="alert">
        {{ Session::get('message') }}
    </div>
    @endif

    <div class="create-agency mt-5">
        <div class="container">
          <h2>Add employee</h2>
          <hr>
          <form method="POST" action="{{route('owner.addEmployeePost')}}" enctype="multipart/form-data">
            @csrf
            <div class="row">
              <div class="col">
                <label for="username" class="form-label">Username</label>
                <input type="text" name="username" class="form-control" placeholder="Username" value="{{ old('username') }}" >
                @error('username')
                    <p style="color:red">{{ $message }}</p>
                @enderror
              </div>
              <div class="col">
                <label for="empType" class="form-label">Role</label>
                <select name="empType" id="" class="form-control">
                    <option value="G">Garage Manager</option>
                    <option value="S">Secretary</option>
                </select>
                @error('empType')
                <p style="color:red">{{ $message }}</p>
                @enderror
            </div>
              
            </div>
            <div class="row">
                <div class="col">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" name="password" class="form-control" placeholder="Password" value="{{ old('password') }}">
                    @error('password')
                    <p style="color:red">{{ $message }}</p>
                    @enderror
                </div>
                <div class="col">
                    <label for="passwordConfirm" class="form-label">Confirm password</label>
                    <input type="password" name="passwordConfirm" class="form-control" placeholder="Confirm password" value="{{ old('passwordConfirm') }}" >
                    @error('passwordConfirm')
                    <p style="color:red">{{ $message }}</p>
                    @enderror
                </div>
              
            </div>
            <div class="row">

                <div class="col">
                    <label for="First name" class="form-label">First name</label>
                    <input type="text" name="firstName" class="form-control" placeholder="First name" value="{{ old('firstName') }}" >
                    @error('firstName')
                    <p style="color:red">{{ $message }}</p>
                    @enderror
                </div>
                <div class="col">
                    <label for="Last name" class="form-label">Last name</label>
                    <input type="text" name="lastName" class="form-control" placeholder="Last name" value="{{ old('lastName') }}" >
                    @error('lastName')
                    <p style="color:red">{{ $message }}</p>
                    @enderror
                </div>
               
            </div>
            <div class="row">
                <div class="col">
                    <label for="birthDate" class="form-label">Birth date</label>
                    <input type="date" name="birthDate" class="form-control" placeholder="Birth date" value="{{ old('birthDate') }}" >
                    @error('birthDate')
                    <p style="color:red">{{ $message }}</p>
                    @enderror
                </div>
                <div class="col">
                    <label for="address" class="form-label">Address</label>
                    <input type="text" name="address" class="form-control" placeholder="Address" value="{{ old('address') }}">
                    @error('address')
                    <p style="color:red">{{ $message }}</p>
                    @enderror
                  </div>
            </div>
            <div class="row">
                <div class="col-6">
                    <label for="branche" class="form-label">Branche</label>
                    <select name="branche" class="form-control" id="">
                        <option value="">Choose a branche</option>
                        @foreach ($branches as $branch)
                            <option value="{{ $branch->brancheID }}">{{ $branch->region }}</option>
                        @endforeach
                    </select>
                    @error('branche')
                    <p style="color:red">{{ $message }}</p>
                    @enderror
                </div>
                <div class="col">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" name="email" class="form-control" placeholder="Email" value="{{ old('email') }}">
                    @error('email')
                    <p style="color:red">{{ $message }}</p>
                    @enderror
                  </div>
            </div>
            <button type="submit" class="btn btn-primary">Save</button>
          </form>
        </div>
      </div>
@endsection

@section('headTags')
<title>Add a new employee</title>
<link rel="stylesheet" href="{{ asset('css/app.css') }}">
<style>
    input{
        margin-bottom: 10px !important;
    }
</style>
@endsection