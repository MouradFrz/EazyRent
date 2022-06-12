<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>login</title>
  <link rel="stylesheet" href="{{ asset('css/bootstrap.css') }}">
  <link rel="stylesheet" href="{{ asset('css/app.css') }}">
  <link rel="stylesheet" href="{{ asset('css/admin/index.css') }}">
</head>
<body>
  <div class="admin-login">
    <div class="login-media"></div>
    <div class="login-pannel">
      <form class="form-authentication" action="{{ route('admin.check') }}" method="POST">
        @csrf
        <h1 class="title">Log in</h1>
        <label for="username" class="label">Username</label>
        <input class="inputs" name="username" type="text" value="{{ old('username') }}" />
        <label for="password" class="label">Password</label>
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
        <div class="d-flex justify-content-center mt-2">
          <button type="submit" class="custom-btn custom-btn-dark">Log in</button>
        </div>
      </form>
    </div>
  </div>
</body>

</html>
