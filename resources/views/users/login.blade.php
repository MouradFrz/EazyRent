<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Login</title>
  <link rel="stylesheet" href="{{ asset('css/bootstrap.css') }}">
  <link rel="stylesheet" href="{{ asset('css/app.css') }}">
  <link rel="stylesheet" href=" {{ asset('css/authentication.css') }}">
</head>

<body>
  <div class="authentication row">
    <div class="authentication_welcome col-12 col-md-4">
      <div class="content">
        <object data="{{asset('images/icons/hi-authentication.svg')}}" width="300" height="300" defer loading="lazy"></object>
        <h2 class="section-heading">welcome back!</h2>
        <p>please enter your personal info to access to your account</p>
        <p>Don't have an account?</p>
        <a href="{{ route('user.register') }}" class="custom-btn">Sign Up</a>
      </div>
    </div>
    <div class="authentication_panel col-12 col-md-8">
      <h2 class="section-header">Log in to eazyrent</h2>
      <div class="content container-fluid">
        <form class="form-authentication" action="{{ route('user.check') }}" method="POST" enctype="multipart/form-data">
          @csrf
          <label for="username">Username or Email</label>
          <input class="inputs" name="username" type="text" value="{{ old('username') }}"/>
          <label for="password">Password</label>
          <input class="inputs" name="password" type="password"/>
          <span>
            <input type="checkbox" name="rememberMe" value="remember me">
            <label for="remember me" class="last">remember me</label>
          </span>
          @error('username')
          <div class="alert alert-danger w-100 alert-dismissible fade show" role="alert">
            {{ $message }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>
          @enderror
          @if (Session::get('fail'))
          <div class="alert alert-danger w-100 alert-dismissible fade show" role="alert">
            {{ Session::get('fail') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>
          @endif
          @if (Session::get('status'))
          <div class="alert alert-success w-100 alert-dismissible fade show" role="alert">
            {{ Session::get('status') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>
          @endif
          @if (Session::get('message'))
          <div class="alert alert-danger w-100 alert-dismissible fade show" role="alert">
            {{ Session::get('message') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>
          @endif
          @if (Session::get('ban'))
          <div class="alert alert-danger w-100 alert-dismissible fade show" role="alert">
            {{ Session::get('ban') }} <br>
            <span class="fw-bold"> Reason:</span> <br>
            {{ Session::get('reason') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>
          @endif
          <div class="d-flex justify-content-center">
            <button type="submit" class="custom-btn custom-btn-dark login-btn">Log in</button>
          </div>
        </form>
        <div class="authentication_options">
          <p class="or">-OR-</p>
          <div class="d-flex justify-content-center mb-2">
            <a href="{{ route('user.loginWithGoogle') }}" class="google-login">
              <object data="{{asset('/images/icons/google-icon.svg')}}" width="24" height="24"></object>
              Login with Google
            </a>
          </div>
          <p >Forgot password? <a href="{{ route('password.email') }}" class="link">Click here </a></p>
        </div>
      </div>
    </div>
  </div>
</body>

</html>
