@extends('layouts.workerLayout')

@section('content')
@if(Session::get('message'))
<div class="alert alert-success w-100 " role="alert">
    {{ Session::get('message') }}
</div>
@endif

<div class="create-agency mt-5">
    <div class="container">
      <h2>Profile </h2>
      <hr>
      <form method="POST" action="{{route('owner.editProfile')}}" enctype="multipart/form-data">
        @csrf
        <div class="row">
            <div>
                {{-- <img src="{{ asset('images/owners/idCardImages/ferza.jpg') }}" alt="" style="width: 150px;border-radius:50%;"> --}}
                <h5>{{ Auth::user()->firstName }} {{ Auth::user()->lastName }}</h5>
                <h6 class="text-muted fw-light">{{ Auth::user()->username }}</h6>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <label for="" class="form-label">Username</label>
                <input type="text" name="username" class="form-control" placeholder="Username" value="{{ Auth::user()->username }}" disabled>
                @error('username')
                    <p style="color:red">{{ $message }}</p>
                    @enderror
            </div>
            <div class="col">
                <label for="" class="form-label">Identity card number</label>
                <input type="text" name="idCard" class="form-control" maxlength="18" placeholder="Identity card number" value="{{ Auth::user()->idCard }}" disabled onkeypress="return isNumber(event)">
                @error('idCard')
                    <p style="color:red">{{ $message }}</p>
                    @enderror
            </div>
        </div>
        <div class="row">
            <div class="col">
                <label for="" class="form-label">First name</label>
                <input type="text" name="firstName" class="form-control" placeholder="First name" value="{{ Auth::user()->firstName }}" disabled>
                @error('firstName')
                    <p style="color:red">{{ $message }}</p>
                    @enderror
            </div>
            <div class="col">
                <label for="" class="form-label">Last name</label>
                <input type="text" name="lastName" class="form-control" placeholder="Last name" value="{{ Auth::user()->lastName }}" disabled>
                @error('lastName')
                    <p style="color:red">{{ $message }}</p>
                    @enderror
            </div>
        </div>
        <div class="row">
            <div class="col">
                <label for="" class="form-label">Birth date</label>
                <input type="date" name="birthDate" class="form-control" placeholder="Birth date" value="{{ Auth::user()->birthDate }}" disabled>
                @error('birthDate')
                    <p style="color:red">{{ $message }}</p>
                    @enderror
            </div>
            <div class="col">
                <label for="" class="form-label">Email</label>
                <input type="text" name="email" class="form-control" placeholder="Email" value="{{ Auth::user()->email }}" disabled>
                @error('email')
                    <p style="color:red">{{ $message }}</p>
                    @enderror
            </div>  
        </div>
        <div class="row">
            <div class="col">
                <label for="" class="form-label">Phone number</label>
                <input type="text" name="phone" class="form-control" maxlength="10" placeholder="Phone number" value="{{ Auth::user()->phoneNumber }}" disabled onkeypress="return isNumber(event)">
                @error('phone')
                    <p style="color:red">{{ $message }}</p>
                    @enderror
            </div>  
            <div class="col">
                <label for="" class="form-label">Address</label>
                <input type="text" name="address" class="form-control" placeholder="Address" value="{{ Auth::user()->address }}" disabled>
                @error('address')
                    <p style="color:red">{{ $message }}</p>
                    @enderror
            </div>
        </div>
        <small class="text-muted ">Leave the new password field empty if you want to keep the same password. *</small>
        <div class="row">
            <div class="col">
                <label for="" class="form-label">New password</label>
                <input type="password" name="newPassword" class="form-control" placeholder="New password" value="" disabled>
                @error('newPassword')
                    <p style="color:red">{{ $message }}</p>
                    @enderror
            </div>
            <div class="col">
                <label for="" class="form-label">Confirm password</label>
                <input type="password" name="passwordConfirm" class="form-control" placeholder="Confirm password" value="" disabled>
                @error('passwordConfirm')
                    <p style="color:red">{{ $message }}</p>
                    @enderror
            </div>  
        </div>
        <div class="row d-flex justify-content-end">
            <div class="col-6">
                <label for="" class="form-label">Current password</label>
                <input type="password" name="currentPassword" class="form-control" placeholder="Current password" value="" disabled>
                @error('currentPassword')
                    <p style="color:red">{{ $message }}</p>
                    @enderror
            </div>
        </div>
        <div class="row m-3">
         
            <div class="col d-flex justify-content-end p-0 m-0 gx-5">
                <button class="btn btn-primary" id="edit-btn">Edit</button>
               <button class="btn btn-success ms-3" type="submit" disabled id="save-btn">Save</button>
            </div>  

        </div>
      </form>

    </div>
  </div>
@endsection

@section('scripts')
    <script>
        let inputs = document.querySelectorAll('.form-control');
        
        document.querySelector('#edit-btn').addEventListener('click',e=>{
            e.preventDefault();
            inputs.forEach(e=>{
                e.disabled=false;
            });
            document.querySelector('#save-btn').disabled=false;
        })

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
@section('headTags')
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
@endsection