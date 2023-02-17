@extends('layouts.userLayout')
@section('head')
<title>confirm password</title>
@endsection
@section('content')
<div class="white-space"></div>
<div class="resset-password" style="min-height: 60vh">
  <div class="content">
    <h1 class="text-center">EazyRent</h1>
    <h3 class="text-center">verify email</h3>
    @if (Session::get('message'))
    <div class="success-icon">
      <i class="fa-solid fa-circle-check"></i>
    </div>
    <p class="text-center text-success">
      {{ Session::get('message') }}
    </p>
    <a href="/" class="link mt-4"><i class="fa-solid fa-arrow-left"></i> Go back home</a>
   @else
    <p class="mt-4">please click the button bellow to send a verification email</p>
    <form action="{{ route('verification.send') }}" method="post"> @csrf
      <button type="submit" class="mt-4 custom-btn custom-btn-success" style="margin: 0 auto">Send a verification email</button>
    </form>
    @endif
  </div>
</div>
<div class="white-space"></div>
@endsection
