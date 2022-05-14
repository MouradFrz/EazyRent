<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Owner Login</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link href="{{ asset('css/login.css') }}" rel="stylesheet">
</head>
<body>

    <div>
        <div
          class="container d-flex justify-content-center align-items-center"
          style="min-height: 100vh"
        >
          <div class="login-panel d-flex justify-content-center align-items-center flex-column">
            <div class="type-buttons d-flex">
              <button class="custom-btn active type-button">Owner</button>
              <button class="custom-btn type-button">Garage Manager</button>
              <button class="custom-btn type-button">Secretary</button>
            </div>
            <form class="form-login-worker form-login d-flex flex-column active" action="{{ route('owner.check') }}" method="POST">
                @csrf
              <h1 class="title">Welcome Back</h1>
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
              
            </form>
            <form class="form-login-worker form-login d-flex flex-column" action="{{ route('garagist.check') }}" method="POST" >
              @csrf
            <h1 class="title">Welcome Back</h1>
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
            
          </form>
          <form class="form-login-worker form-login d-flex flex-column" action="{{ route('secretary.check') }}" method="POST" >
            @csrf
          <h1 class="title">Welcome Back</h1>
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
          
        </form>
            <p class="align-self-start">
              Want to add your agency?
              <a href="{{ route('owner.register') }}" class="text-decoration-underline "
                >Sign Up!</a
              >
            </p>
          </div>
        </div>
      </div>
      <script>
        let buttons = document.querySelectorAll('.type-button') 
        let forms = document.querySelectorAll('.form-login')
        console.log(forms)
        buttons.forEach((e,i)=>{
          e.addEventListener('click',()=>{
            buttons.forEach((el)=>{
              el.classList.remove('active');
            });
            e.classList.add('active');
            forms.forEach((el)=>{
              el.classList.remove('active');
            })
            forms[i].classList.add('active');
          })
        });
      </script>
</body>
</html>