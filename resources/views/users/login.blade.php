<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Login</title>
  <link rel="stylesheet" href="{{ asset('css/bootstrap.css') }}">
  <link rel="stylesheet" href="{{ asset('css/app.css') }}">
  <link rel="stylesheet" href=" {{ asset('css/login.css') }}">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.3/font/bootstrap-icons.css">
</head>

<body>
  <div class="login row">
    <div class="login_welcome col-12 col-md-4">
      <div class="content">
        <h2 class="section-heading">welcome back!</h2>
        <p>please enter your personal info to access to your account</p>
        <p>
          Don't have an account?
          <a href="{{ route('user.register') }}" class="link">Sign Up</a>
        </p>
      </div>
    </div>
    <div class="login_panel col-12 col-md-8">
      <h2 class="section-header">Log in to eazyrent</h2>
      <div class="content container-fluid">
        <form class="form-login d-flex flex-column" action="{{ route('user.check') }}" method="POST">
          @csrf
          <label for="username">Username</label>
          <input class="inputs" name="username" type="text" value="{{ old('username') }}"
            placeholder="enter username here" />
          <label for="password">Password</label>
          <input class="inputs" name="password" type="password" placeholder="enter password here" />
          <span>
            <input type="checkbox" name="rememberMe" value="remember me">
            <label for="remember me" class="last">remember me</label>
          </span>
          @error('username')
          <div class="alert alert-danger w-100" role="alert">
            {{ $message }}
          </div>
          @enderror
          @if (Session::get('fail'))
          <div class="alert alert-danger w-100" role="alert">
            {{ Session::get('fail') }}
          </div>
          @endif
          @if (Session::get('message'))
          <div class="alert alert-danger w-100" role="alert">
            {{ Session::get('message') }}
          </div>
          @endif
          @if (Session::get('ban'))
          <div class="alert alert-danger w-100" role="alert">
            {{ Session::get('ban') }} <br>
            <span class="fw-bold"> Reason:</span> <br>
            {{ Session::get('reason') }}
          </div>
          @endif
          <div class="d-flex justify-content-center">
            <button type="submit" class="custom-btn custom-btn-dark login-btn">log in</button>
          </div>
        </form>
        <div class="login_options">
          <p class="or">-or-</p>
          <p>forget Password ? <a href="#" class="link">click here</a></p>
          <div class="d-flex justify-content-center">
            <button href="{{ route('user.loginWithGoogle') }}" class="google-login">
              <object data="{{asset('/images/icons/google-icon.svg')}}" width="24" height="24"></object>
              Login with Google
            </button>
          </div>
        </div>
      </div>
    </div>
  </div>
</body>

</html>
