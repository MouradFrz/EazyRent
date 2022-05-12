<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>User Login</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link href="{{ asset('css/login.css') }}" rel="stylesheet">
</head>
<body>

    <div>
        <div
          class="container d-flex justify-content-center align-items-center"
          style="min-height: 100vh"
        >
          <div class="login-panel d-flex justify-content-center align-items-center">
            <form class="form-login d-flex flex-column" action="{{ route('user.check') }}" method="POST">
                @csrf
              <h1 class="title">Log in</h1>
              <label for="">Username</label>
              <input class="inputs" name="username" type="text" value="{{ old('username') }}"/>
              <label for="">Password</label>
              <input class="inputs" name="password" type="password" />
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
              <a href="" class="text-decoration-underline">Forgot password?</a>
              <input
                style="margin-top: 15px; width: 150px"
                type="submit"
                value="Log in"
                class="custom-btn"
              />
              <p>
                Don't have an account?
                <a href="{{ route('user.register') }}" class="text-decoration-underline"
                  >Sign Up!</a
                >
              </p>
            </form>
          </div>
        </div>
      </div>
</body>
</html>