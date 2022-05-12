<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Signup</title>
    <link rel="stylesheet" href="{{ asset('css/register.css') }}">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body>

    @if (Session::get('success'))
        {{ Session::get('success') }}
    @endif
    @if (Session::get('fail'))
        {{ Session::get('fail') }}
    @endif

    {{ Auth::user() }}
{{--
    <form action="" method="POST">
        @csrf
        <input type="text" name="firstName" id="" placeholder="firstName">
        <input type="text" name="lastName" id="" placeholder="lastName">
        <input type="text" name="address" id="" placeholder="address">
        <input type="date" name="birthDate" id="" placeholder="birthDate">
        <input type="text" name="username" id="" placeholder="username">
        <input type="text" name="email" id="" placeholder="email">
        <input type="text" name="password" id="" placeholder="password">
        <input type="text" name="idCard" id="" placeholder="idCard">
        <input type="submit" value="SignUp">
    </form> --}}

    <div id="app">
        <div
          class="container d-flex justify-content-center align-items-center "
          style="min-height: 100vh"
            >
          <form
            class="signup-panel d-flex align-items-center justify-content-center flex-column"
            action="{{ route('user.create') }}"
            method="POST"
            >
          <h1 class="title">Sign Up</h1>
          @csrf
            <div class="form-login d-flex flex-column w-100" v-if="signUpStep == 1">
              <label for="">First name</label>
              <input
                type="text"
                name="firstName"
                maxlength="45"
                class="inputs"
                value="{{ old('firstName') }}"
              />
              <span class="text-danger" style="font-size:0.8rem">
                    @error('firstName')
                        {{ $message }}
                    @enderror
              </span>

              <label for="">Last name</label>
              <input
                type="text"
                name="lastName"
                maxlength="45"
                class="inputs"
                value="{{ old('lastName') }}"
              />
              <span class="text-danger" style="font-size:0.8rem">
                @error('lastName')
                    {{ $message }}
                @enderror
                </span>
              <label for="">Birth Date</label>
              <input
              class="inputs"
                type="date"
                name="birthDate"
                max="2003-01-01"
                value="{{ old('birthDate') }}"
              />
              <span class="text-danger" style="font-size:0.8rem">
                @error('date')
                    {{ $message }}
                @enderror
                 </span>
              <label for="">Address</label>
              <input
              class="inputs"
                type="text"
                name="address"
                value="{{ old('address') }}"
              />
              <span class="text-danger" style="font-size:0.8rem">
                @error('address')
                    {{ $message }}
                @enderror
                </span>
              <p class="step-index">1/4</p>
            </div>
            <div class="form-login d-flex flex-column" v-if="signUpStep == 2">
              <label for="">Username</label>
              <input
                class="inputs"
                type="text"
                name="username"
                value="{{ old('username') }}"
              />
              <span class="text-danger" style="font-size:0.8rem">
                @error('inputs')
                    {{ $message }}
                @enderror
               </span>
              <label for="">E-mail</label>
              <input
                class="inputs"
                type="email"
                value="{{ old('email') }}"
                name="email"
              />
              <span class="text-danger" style="font-size:0.8rem">
                @error('email')
                    {{ $message }}
                @enderror
                </span>
              <label for=""
                >Phone number
                <span style="font-size: 10px; color: gray">optional</span></label
              >
              <input
                class="inputs"
                type="text"
                maxlength="10"
                name="phone"
                value="{{ old('phone') }}"
              />
              <span class="text-danger" style="font-size:0.8rem">
                @error('phone')
                    {{ $message }}
                @enderror
                </span>
              <div class="d-flex flex-column">
                <label for="">Password</label>
                <input
                  class="inputs"
                  type="password"
                  name="password"
                />
                <span class="text-danger" style="font-size:0.8rem">
                    @error('password')
                        {{ $message }}
                    @enderror
              </span>
                <label for="">Password confirmation</label>
                <input
                  class="inputs"
                  type="password"
                  name="passwordConfirm"
                />
                <span class="text-danger" style="font-size:0.8rem">
                    @error('passwordConfirm')
                        {{ $message }}
                    @enderror
              </span>
              </div>
              <p class="step-index">2/4</p>
            </div>
            <div class="form-login d-flex flex-column" v-if="signUpStep == 3">
              <label for=""> Identity card number</label>
              <input
                class="inputs"
                type="text"
                maxlength="18"
                name="idCard"
                value="{{ old('idCard') }}"
              />
              <span class="text-danger" style="font-size:0.8rem">
                @error('idCard')
                    {{ $message }}
                @enderror
                </span>

              <label for="">Upload an image of your identity card</label>
              <input
                class="inputs file-input"
                type="file"
                accept="image/*"
                name=""
                style="display: none"
                id="file-field"
              />
              <div

                class="image-selector"
                alt=""
              ></div>
              <img

                class="image-preview"
                alt=""
              />
              <div class="d-flex justify-content-between">

              </div>
              <p class="step-index">3/4</p>
            </div>
            <div class="form-login d-flex flex-column" v-if="signUpStep == 4">
              <label for=""
                >Upload an image where your face is clearly visible</label
              >
              <input
                class="inputs file-input"
                type="file"
                accept="image/*"
                name=""
              />
              <div class="d-flex justify-content-between">
                <input
                  style="margin-top: 15px; width: 150px; align-self: flex-end"
                  type="submit"
                  value="Sign up!"
                  class="custom-btn"
                />
              </div>
              <p class="step-index">4/4</p>
            </div>
            <div class="d-flex justify-content-between">
                <button
                  style="margin-top: 15px; width: 150px"
                  @click="stepDec"
                  class="custom-btn"
                >
                  Previous
                </button>
                <button
                  style="margin-top: 15px; width: 150px; align-self: flex-end"
                  @click="stepInc"
                  class="custom-btn"
                  v-if="signUpStep < 4"
                >
                  Next
                </button>
                <input
                style="margin-top: 15px; width: 150px; align-self: flex-end"
                type="submit"
                value="Sign up!"
                class="custom-btn"
                v-if=" signUpStep == 4"
              />
              </div>
            <p class="my-2">
                Already have an account?
                <a href="{{ route('user.login') }}" class="text-decoration-underline">Log in</a>
            </p>
          </form>
        </div>
      </div>
      <script src="https://unpkg.com/vue@3"></script>
      <script>
        Vue.createApp({
            data() {
                return {
                    signUpStep: 1,
                }
            },
            methods: {
            openFilePicker(){
                document.getElementById("file-field").click()
            },
            stepInc() {
                (this.signUpStep < 4 ) ? this.signUpStep++ : this.signUpStep = 4;
            },
            stepDec() {
                (this.signUpStep > 1 ) ? this.signUpStep-- : this.signUpStep = 1;
            },
            onlyNumber($event) {
            let keyCode = $event.keyCode ? $event.keyCode : $event.which;
            if (keyCode < 48 || keyCode > 57) {
                $event.preventDefault();
            }
            },
        },
        }).mount('#app')
    </script>
</body>
</html>
