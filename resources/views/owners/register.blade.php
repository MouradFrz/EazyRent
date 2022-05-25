<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Signup</title>
    <link rel="stylesheet" href="{{ asset('css/register.css') }}">
    <link rel="stylesheet" href="{{ asset('css/bootstrap.css') }}">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <style>
      .hide{
        position: absolute;
       visibility: hidden;
       z-index: -10;
      }
    </style>
</head>
<body>
    <div>
        <div
          class="container d-flex justify-content-center align-items-center "
          style="min-height: 100vh"
        >
        <div class="signup-panel d-flex align-items-center justify-content-center flex-column" >
          <form
            class=" d-flex align-items-center justify-content-center flex-column"
            action="{{ route('owner.create') }}"
            method="POST"
            style="width: 100%"
            enctype="multipart/form-data"
          >
          <h1 class="title fw-bold">Sign up</h1>
          @if (Session::get('fail'))
          <div class="alert alert-danger w-100" role="alert">
              {{ Session::get('fail') }}
            </div>
          @endif
          @if (Session::get('success'))
          <div class="alert alert-success w-100 " role="alert">
            {{ Session::get('success') }}
          </div>
          @endif
          @csrf
            <div class="form-login d-flex flex-column w-100 signupStep">
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
                @error('birthDate')
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
                <p class="my-2">
                  Already have an account?
                  <a href="{{ route('workerLogin') }}" class="text-decoration-underline">Log in</a>
              </p>
              <p class="step-index">1/3</p>
            </div>
            <div class="form-login d-flex flex-column signupStep hide"  >
              <label for="">Username</label>
              <input
                class="inputs"
                type="text"
                name="username"
                value="{{ old('username') }}"
              />
              <span class="text-danger" style="font-size:0.8rem">
                @error('username')
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
                onkeypress="return isNumber(event)"
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
              <p class="step-index">2/3</p>
            </div>
            <div class="form-login d-flex flex-column signupStep hide">
              <label for=""> Identity card number</label>
              <input
                class="inputs"
                type="text"
                maxlength="18"
                name="idCard"
                value="{{ old('idCard') }}"
                onkeypress="return isNumber(event)"
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
                name="idCardImage"
                style="display: none"
                id="file-field"
                value="{{ old('idCardImage') }}"
              />
              <span class="text-danger" style="font-size:0.8rem">
              @error('idCardImage')
                {{ $message }}
              @enderror
            </span>
              <div

                class="image-selector"
                alt=""
                onclick="openFilePicker()"
              ></div>
              <img
              onclick="openFilePicker()"
                class="image-preview"
                alt=""
              />
              <div class="d-flex justify-content-end ">
                <input
                  style="margin-top: 15px !important; width: 150px;"
                  type="submit"
                  value="Sign up!"
                  class="custom-btn"
                />
              </div>
              <p class="step-index">3/3</p>
            </div>
          </form>
          <div class="d-flex justify-content-between w-100">
            <button
                    style="margin-top: 15px; width: 150px"
                    class="custom-btn"
                    id="prev"
                  >
                    Previous
                  </button>
                  <button
                    style="margin-top: 15px; width: 150px; align-self: flex-end"
                    class="custom-btn"
                    id="next"
                  >
                    Next
                </button>
              </div>


        </div>
        </div>
      </div>
      <script>
        const pages = document.querySelectorAll('.signupStep')
        const stepInc = document.querySelector('#next')
        const stepDec = document.querySelector('#prev')

        let currentStep=0;
        stepDec.disabled=true;
        // stepDec.style.backgroundColor ='gray'
        stepInc.addEventListener('click',()=>{
          currentStep++;
          pages.forEach(element => {
            element.classList.add('hide');
          });
            pages[currentStep].classList.remove("hide");
          if(currentStep==2){
            // stepInc.style.backgroundColor ='gray'
            stepInc.disabled=true;
          }
          if(currentStep!=2){
            // stepDec.style.backgroundColor ='rgb(187, 190, 105)'
            stepDec.disabled=false;
          }
        });

        stepDec.addEventListener('click',()=>{
          currentStep--;
          pages.forEach(element => {
            element.classList.add('hide');
          });
            pages[currentStep].classList.remove("hide");
          if(currentStep==0){
            // stepDec.style.backgroundColor ='gray'
            stepDec.disabled=true;
          }
          if(currentStep!=2){
            // stepInc.style.backgroundColor ='rgb(187, 190, 105)'
            stepInc.disabled=false;
          }
        });

        function isNumber(evt) {
          evt = (evt) ? evt : window.event;
          var charCode = (evt.which) ? evt.which : evt.keyCode;
            if (charCode > 31 && (charCode < 48 || charCode > 57)) {
              return false;
            }
    return true;
}

// function imageSelected(e){
//       var reader,files = e.target.files
//       if(files.length ===0){
//         console.log('empty')
//       }
//       console.log("executed")
//       reader = new FileReader()

//       reader.onload = (e)=>{
//         this.user.idCardImage=e.target.result
//       }
//       reader.readAsDataURL(files[0]);
//     }


      document.querySelector('#file-field').onchange = evt => {
         const [file] = document.querySelector('#file-field').files
          if (file) {
            document.querySelector('.image-preview').src = URL.createObjectURL(file)
            document.querySelector('.image-selector').style.display="none";
         }
}
// document.querySelector('#file-field-face').onchange = evt => {
//          const [file] = document.querySelector('#file-field-face').files
//           if (file) {
//             document.querySelector('#image-preview-face').src = URL.createObjectURL(file)
//             document.querySelector('#image-selector-face').style.display="none";
//          }
// }


    function openFilePicker(){
      document.getElementById("file-field").click()
    }
    function openFilePickerFace(){
      document.getElementById("file-field-face").click()
    }
      </script>
      {{-- <script src="https://unpkg.com/vue@3"></script>
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
    </script> --}}
</body>
</html>
