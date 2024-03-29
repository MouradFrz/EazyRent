@extends('layouts.userLayout')
@section('head')
<title>forget password</title>
@endsection
@section('content')
<div class="white-space"></div>
<div class="resset-password">
  <div class="content">
    <h1 class="text-center">EazyRent</h1>
    <h3 class="text-center">reset your passowrd</h3>
    @if (Session::get('status'))
    <div class="success-icon">
      <i class="fa-solid fa-circle-check"></i>
    </div>
    <p class="text-center text-success">
      {{ Session::get('status') }}
    </p>
    <a href="/" class="link mt-4"><i class="fa-solid fa-arrow-left"></i> Go back home</a>
    @else
    <p class="mb-4 mt-4">Enter the email address associated with your account and we'll send you a link to reset your
      password</p>
    <form action="{{ route('password.request') }}" method="post" enctype="multipart/form-data"
      class="form resset-password-form">
      @csrf
      <label for="email" class="label">Email</label>
      <input type="text" name="email" class="inputs">
      @error('email')
      <p class="danger">{{ $message }}</p>
      @enderror
      <div class="d-flex justify-content-center">
        <button type="submit" class="custom-btn custom-btn-dark mt-3">Submit</button>
      </div>
    </form>
    @endif
  </div>
</div>
<div class="white-space"></div>
@endsection
