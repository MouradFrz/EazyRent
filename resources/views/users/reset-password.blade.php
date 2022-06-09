@extends('layouts.userLayout')
@section('head')
@endsection
@section('content')
<div class="white-space"></div>
<div class="resset-password">
  <div class="content">
    <h1 class="text-center">EazyRent</h1>
    <h3 class="text-center">password resset</h3>
    <form action="{{ route('password.update') }}" method="post" enctype="multipart/form-data" class="form resset-password-form">
      @csrf
      <label for="email" class="email">Email</label>
      <input type="text" name="email" class="inputs" value="{{old('email')}}">
      @error('email')
      <p class="danger">{{ $message }}</p>
      @enderror
      <label for="password">Password</label>
      <input type="password" name="password" class="inputs">
      @error('password')
      <p class="danger">{{ $message }}</p>
      @enderror
      <label for="confirm password">Confirm Password</label>
      <input type="password" name="password_confirmation" class="inputs">
      @error('password_confirmation')
      <p class="danger">{{ $message }}</p>
      @enderror
      <input type="text" name="token" style="display: none" value="{{ $token }}" id="">
      <div class="d-flex justify-content-center">
        <button type="submit" class="custom-btn custom-btn-dark mt-3">submit</button>
      </div>
    </form>
  </div>
</div>

@endsection
