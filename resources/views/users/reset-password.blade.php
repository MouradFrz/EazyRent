@extends('layouts.userLayout')
@section('head')
@endsection
@section('content')
<div class="test">
</div>
<form action="{{ route('password.update') }}" method="post">
  @csrf
  <input type="text" placeholder="Email" name="email">
  @error('email')
  {{ $message }}
  @enderror
  <input type="text" placeholder="Password" name="password">
  @error('password')
  {{ $message }}
  @enderror
  <input type="text" placeholder="Confirm Password" name="password_confirmation">
  @error('password_confirmation')
  {{ $message }}
  @enderror
  <input type="text" name="token" style="display: none" value="{{ $token }}" id="">
  <button type="submit">Submit</button>
</form>
@endsection
