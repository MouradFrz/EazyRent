@extends('layouts.workerLayout')
@section('headTags')
<title>add employee</title>
<link rel="stylesheet" href="{{ asset('css/app.css') }}">
<link rel="stylesheet" href="{{ asset('css/owner/index.css') }}">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css"
  integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g=="
  crossorigin="anonymous" referrerpolicy="no-referrer" />
@endsection
@section('content')
<script>
  let employees = document.querySelector('#employees')
  employees.classList.add('active')
</script>
    @if(Session::get('message'))
    <div class="alert alert-success w-100 alert-dismissible fade show" role="alert">
        {{ Session::get('message') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif
    <div class="add-employee">
        <div class="container">
          <h2 class="title">add an employee</h2>
          <form method="POST" action="{{route('owner.addEmployeePost')}}" enctype="multipart/form-data">
            @csrf
            <div class="row">
              <div class="col">
                <label for="username">Username</label>
                <input type="text" name="username" class="inputs" placeholder="Username" value="{{ old('username') }}" >
                @error('username')
                    <p style="color:red">{{ $message }}</p>
                @enderror
              </div>
              <div class="col">
                <label for="employee type">Role</label>
                <select name="empType" id="" class="inputs">
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
                    <label for="password">Password</label>
                    <input type="password" name="password" class="inputs" placeholder="Password" value="{{ old('password') }}">
                    @error('password')
                    <p style="color:red">{{ $message }}</p>
                    @enderror
                </div>
                <div class="col">
                    <label for="passwordConfirm">Confirm password</label>
                    <input type="password" name="passwordConfirm" class="inputs" placeholder="Confirm password" value="{{ old('passwordConfirm') }}" >
                    @error('passwordConfirm')
                    <p style="color:red">{{ $message }}</p>
                    @enderror
                </div>

            </div>
            <div class="row">
                <div class="col">
                    <label for="First name">First name</label>
                    <input type="text" name="firstName" class="inputs" placeholder="First name" value="{{ old('firstName') }}" >
                    @error('firstName')
                    <p style="color:red">{{ $message }}</p>
                    @enderror
                </div>
                <div class="col">
                    <label for="Last name">Last name</label>
                    <input type="text" name="lastName" class="inputs" placeholder="Last name" value="{{ old('lastName') }}" >
                    @error('lastName')
                    <p style="color:red">{{ $message }}</p>
                    @enderror
                </div>

            </div>
            <div class="row">
                <div class="col">
                    <label for="birthDate">Birth date</label>
                    <input type="date" name="birthDate" class="inputs" placeholder="Birth date" value="{{ old('birthDate') }}" >
                    @error('birthDate')
                    <p style="color:red">{{ $message }}</p>
                    @enderror
                </div>
                <div class="col">
                    <label for="address">Address</label>
                    <input type="text" name="address" class="inputs" placeholder="Address" value="{{ old('address') }}">
                    @error('address')
                    <p style="color:red">{{ $message }}</p>
                    @enderror
                  </div>
            </div>
            <div class="row">
                <div class="col-6">
                    <label for="branche">Branche</label>
                    <select name="branche" class="inputs" id="">
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
                    <label for="email">Email</label>
                    <input type="email" name="email" class="inputs" placeholder="Email" value="{{ old('email') }}">
                    @error('email')
                    <p style="color:red">{{ $message }}</p>
                    @enderror
                  </div>
            </div>
            <div class="d-flex justify-content-center mt-4">
              <button type="submit" class="custom-btn custom-btn-success">add a new employee</button>
            </div>
          </form>
        </div>
        <div class="white-space"></div>
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
