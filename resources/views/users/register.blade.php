<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Sign up</title>
  <link rel="stylesheet" href="{{ asset('css/bootstrap.css') }}">
  <link rel="stylesheet" href="{{ asset('css/app.css') }}">
  <link rel="stylesheet" href="{{ asset('css/authentication.css') }}">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" rel="stylesheet" defer>
</head>

<body>
  <div class="authentication row">
    <div class="authentication_welcome col-12 col-md-4">
      <div class="content">
        <object data="{{asset('images/icons/hi-authentication.svg')}}" width="300" height="300" defer
          loading="lazy"></object>
        <h2 class="section-heading">Welcome!</h2>
        <p>Please enter your personal info to join us</p>
        <p>You already have an account? </p>
        <div class="d-flex justify-content-center">
          <a href="{{ route('user.login') }}" class="custom-btn">Log in</a>
        </div>
      </div>
    </div>
    <div class="authentication_panel col-12 col-md-8">
      <h2 class="section-header">Join eazyrent</h2>
      <div class="content containter-fluid">
        <form class="form-authentication" action="{{ route('user.create') }}" method="POST"
          enctype="multipart/form-data">
          @csrf
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
          <div class="form-authentication signupStep">
            <label for="first name">First name</label>
            <input type="text" name="firstName" maxlength="45" class="inputs" value="{{ old('firstName') }}" />
            <span class="text-danger">
              @error('firstName')
              {{ $message }}
              @enderror
            </span>
            <label for="last name">Last name</label>
            <input type="text" name="lastName" maxlength="45" class="inputs" value="{{ old('lastName') }}" />
            <span class="text-danger">
              @error('lastName')
              {{ $message }}
              @enderror
            </span>
            <label for="birth date">Birth Date</label>
            <input class="inputs" type="date" name="birthDate" max="2003-01-01" value="{{ old('birthDate') }}" />
            <span class="text-danger">
              @error('birthDate')
              {{ $message }}
              @enderror
            </span>
            <label for="address">Address</label>
            <input class="inputs" type="text" name="address" value="{{ old('address') }}" />
            <span class="text-danger">
              @error('address')
              {{ $message }}
              @enderror
            </span>
            <p class="step-index">1/4</p>
          </div>
          <div class="form-authentication signupStep hide">
            <label for="username">Username</label>
            <input class="inputs" type="text" name="username" value="{{ old('username') }}" />
            <span class="text-danger">
              @error('username')
              {{ $message }}
              @enderror
            </span>
            <label for="email">E-mail</label>
            <input class="inputs" type="email" value="{{ old('email') }}" name="email" />
            <span class="text-danger">
              @error('email')
              {{ $message }}
              @enderror
            </span>
            <label for="phone number">Phone number
              <span style="font-size: 10px; color: gray">optional</span></label>
            <input class="inputs" type="text" maxlength="10" name="phone" value="{{ old('phone') }}"
              onkeypress="return isNumber(event)" />
            <span class="text-danger">
              @error('phone')
              {{ $message }}
              @enderror
            </span>
            <div class="d-flex flex-column">
              <label for="password">Password</label>
              <input class="inputs" type="password" name="password" />
              <span class="text-danger">
                @error('password')
                {{ $message }}
                @enderror
              </span>
              <label for="password confirmation">Password confirmation</label>
              <input class="inputs" type="password" name="passwordConfirm" />
              <span class="text-danger">
                @error('passwordConfirm')
                {{ $message }}
                @enderror
              </span>
            </div>
            <p class="step-index">2/4</p>
          </div>
          <div class="form-authentication signupStep hide">
            <label for="identity card number"> Identity card number</label>
            <input class="inputs" type="text" maxlength="18" name="idCard" value="{{ old('idCard') }}"
              onkeypress="return isNumber(event)" />
            <span class="text-danger" style="font-size:0.8rem">
              @error('idCard')
              {{ $message }}
              @enderror
            </span>
            <label for="identity card image">Upload an image of your identity card</label>
            <input class="inputs file-input" type="file" accept="image/*" name="idCardImage" style="display: none"
              id="file-field" value="{{ old('idCardImage') }}" />
            <span class="text-danger" style="font-size:0.8rem">
              @error('idCardImage')
              {{ $message }}
              @enderror
            </span>
            <div class="image-selector" alt="" onclick="openFilePicker()"></div>
            <img onclick="openFilePicker()" class="image-preview" alt="" />
            <p class="step-index">3/4</p>
          </div>
          <div class="form-authentication signupStep hide">
            <label for="">Upload an image where your face is clearly visible</label>
            <input class="inputs file-input" type="file" accept="image/*" name="faceIdImage" style="display: none"
              id="file-field-face" />
            <span class="text-danger" style="font-size:0.8rem">
              @error('faceIdImage')
              {{ $message }}
              @enderror
            </span>
            <div class="image-selector" id="image-selector-face" alt="" onclick="openFilePickerFace()"></div>
            <div class="spinner" id="loading" style="display: none"></div>
            <img onclick="openFilePickerFace()" class="image-preview" id="image-preview-face" alt="" />
            <span id="verification"></span>
            <p class="step-index">4/4</p>
          </div>
          <div class="d-flex justify-content-between align-items-center">
            <button class="custom-btn custom-btn-dark" id="prev" onclick="event.preventDefault()" type="text">
              Previous
            </button>
            <button class="custom-btn custom-btn-dark" id="next" onclick="event.preventDefault()" type="text">
              Next
            </button>
            <input type="submit" class="custom-btn custom-btn-dark d-none" id="submit-button" value="Sign up">
          </div>
        </form>
      </div>
    </div>
  </div>
  <script src="{{ asset('js/face-api.min.js') }}"></script>
  <script>
        const imageUpload = document.getElementById('file-field-face')
        const pages = document.querySelectorAll('.signupStep')
        const stepInc = document.querySelector('#next')
        const stepDec = document.querySelector('#prev')
        const submitBtn = document.querySelector('#submit-button')
        const loading = document.querySelector('#loading')
        let currentStep=0;
        stepDec.disabled=true;
        stepInc.addEventListener('click',()=>{
          currentStep++;
          pages.forEach(element => {
            element.classList.add('hide');
          });
          pages[currentStep].classList.remove("hide");

          if(currentStep==3){
            stepInc.disabled=true;
            stepInc.classList.add('d-none')
            submitBtn.classList.remove('d-none')
          }
          if(currentStep==1) {
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
            stepDec.disabled=true;
          }
          if(currentStep==2){
            stepInc.disabled=false;
            stepInc.classList.remove('d-none')
            submitBtn.classList.add('d-none')
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
            const models_uri = ""
 Promise.all([
            faceapi.nets.ssdMobilenetv1.loadFromUri('/models')
            ]).then(start)
  function start(){
    const submitButton = document.querySelector('#submit-button');

    submitButton.disabled = true

          imageUpload.addEventListener('change',async ()=>{
            document.querySelector('#image-preview-face').style.display='none';
            document.querySelector('#image-selector-face').style.display="block";
            document.querySelector('#verification').textContent=''
            submitButton.disabled = true
            const [file] = document.querySelector('#file-field-face').files
            if (file) {
              document.querySelector('#image-selector-face').style.display="none";
              document.querySelector('#image-preview-face').style.display='block';
          loading.style.display='block';
          const image = await faceapi.bufferToImage(imageUpload.files[0])
          const detections = await faceapi.detectAllFaces(image)

           const verification = document.querySelector('#verification');
           loading.style.display='none';
            document.querySelector('#image-preview-face').src = URL.createObjectURL(file)


          if(detections.length == 1){
              verification.textContent = "Your image is valid"
              verification.style.color="green"
              submitButton.disabled = false
          }else{
            verification.textContent = "Your image invalid, please choose a more clear picture"
              verification.style.color="red"
              submitButton.disabled = true
          }
          }})
        }
        start()

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
document.querySelector('#file-field-face').onchange = evt => {


}


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
@section('scripts')
<script defer src="{{ asset('js/face-api.min.js') }}"></script>
<script defer src="{{ asset('js/faceScript.js') }}"></script>
@endsection
