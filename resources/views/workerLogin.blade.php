<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Agency Login</title>
  <link rel="stylesheet" href="{{ asset('css/bootstrap.css') }}">
  <link rel="stylesheet" href="{{ asset('css/app.css') }}">
  <link rel="stylesheet" href="{{ asset('css/authentication.css') }}">
</head>

<body>
  <div class="authentication row">
    <div class="authentication_welcome col-12 col-md-4">
      <div class="content align-self-start">
        <object data="{{asset('images/icons/hi-authentication.svg')}}" width="300" height="300" defer
          loading="lazy"></object>
        <h2 class="section-heading">welcome back!</h2>
        <p>please enter your personal info to access to your account</p>
        <p>Want to add your agency?</p>
        <a href="{{ route('owner.register') }}" class="custom-btn">Sign Up</a>
      </div>
    </div>
    <div class="authentication_panel col-12 col-md-8">
      <h2 class="section-header">Log in to eazyrent</h2>
      <div class="content container-fluid">
        <div class="worker-type">
          <button class="custom-btn active">Owner</button>
          <button class="custom-btn">Garage Manager</button>
          <button class="custom-btn">Secretary</button>
        </div>
        <form class="form-authentication" action="{{ route('owner.check') }}"
          method="POST">
          @csrf
          <h1 class="title">owner</h1>
          <label for="">Username</label>
          <input class="inputs" name="username" type="text" value="{{ old('username') }}" />
          <label for="">Password</label>
          <input class="inputs" name="password" type="password" />
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
          <div class="d-flex justify-content-center">
            <input class="custom-btn custom-btn-dark login-btn" type="submit" value="Log in" class="custom-btn" />
          </div>
        </form>
        <form class="form-authentication hide" action="{{ route('garagist.check') }}"
          method="POST">
          @csrf
          <h1 class="title">Garagist</h1>
          {{-- just for debugging --}}
          <label for="">Username</label>
          <input class="inputs" name="username" type="text" value="{{ old('username') }}" />
          <label for="">Password</label>
          <input class="inputs" name="password" type="password" />
          <span>
            <input type="checkbox" name="rememberMe" value="remember me">
            <label for="remember me" class="last">Remember me</label>
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
          <div class="d-flex justify-content-center">
            <input class="custom-btn custom-btn-dark" type="submit" value="Log in" class="custom-btn login-btn" />
          </div>
        </form>
        <form class="form-authentication hide" action="{{ route('secretary.check') }}"
          method="POST">
          @csrf
          <h1 class="title">secretary</h1>
          <label for="">Username</label>
          <input class="inputs" name="username" type="text" value="{{ old('username') }}" />
          <label for="">Password</label>
          <input class="inputs" name="password" type="password" />
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
          <div class="d-flex justify-content-center">
            <input class="custom-btn custom-btn-dark login-btn" type="submit" value="Log in"/>
          </div>
        </form>
        <p>
          forget your password? <a href="" class="link">click here</a>
        </p>
      </div>
    </div>
  </div>
  </div>
  <script>
    let buttons = document.querySelectorAll('.worker-type>button')
    let forms = document.querySelectorAll('.form-authentication')
    console.log(forms)
    buttons.forEach((e,i)=>{
      e.addEventListener('click',()=>{
        buttons.forEach((el)=>{
          el.classList.remove('active');
        });
        e.classList.add('active');
        forms.forEach((el)=>{
          el.classList.add('hide');
        })
        forms[i].classList.remove('hide');
      })
    });
  </script>
</body>

</html>
