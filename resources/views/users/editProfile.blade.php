@extends('layouts.userLayout')

@section('content')
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Confirm change</h5>
        </div>
        <div class="modal-body">
          <label for="" class="label">Enter your current password</label>
          <input type="password" class="inputs" name="region" id="curpw">
          <span id="errorspan" class="text-danger"></span>
        </div>
        <div class="modal-footer">
          <button type="button" class="link link-secondary" data-bs-dismiss="modal">Close</button>
          <button type="button" class="link" id="confirm">Confirm</button>
        </div>
      </div>
    </div>
  </div>
</div>
<div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalLabel">Crop your image</h5>
      </div>
      <div class="modal-body">
        <div class="img-container">
          <div class="row">
            <div class="col-md-8">
              <img id="image" src="">
            </div>
            <div class="col-md-4">
              <div class="preview"></div>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="link link-secondary" data-bs-dismiss="modal">Cancel</button>
          <button type="button" class="link" id="crop">change immage</button>
        </div>
      </div>
    </div>
  </div>
</div>
<div class="edit-profile">
  <div class="container mt-5">
    @if(Session::get('message'))
    <div class="alert alert-success w-100 alert-dismissible fade show" role="alert">
      {{ Session::get('message') }}
      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
      </button>
    </div>
    @endif
    <div class="alert alert-success w-100 alert-dismissible fade show" style="display: none" role="alert" id="alert">
      Your image has been changed successfully. Reload the page the view the change
      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
      </button>
    </div>
    <div class="row editform">
      <div class="col-4  gx-1">
        <div>
          <div class="d-flex flex-column align-items-center justify-content-center">
            <div class="profile-img">
              @if(!is_null(Auth::user()->profilePath))
              <img src="{{ asset('images/users/profile/'.Auth::user()->username.'_profile.png') }}" alt=""
                class="image-selector-open" id="profile-image">
              @else
              <img src="{{ asset('images/download.png') }}" alt="" class="image-selector-open" id="profile-image">
              @endif
            </div>
            <input type="file" name="image" class="image" style="display: none" id="image-input">
            <strong class="username">{{ Auth::user()->username }}</strong>
            <p id="fullname">{{ Auth::user()->lastName }} {{ Auth::user()->firstName }}</p>
            <strong>Identity card number:</strong>
            <h6 class="text-muted">{{ Auth::user()->idCard }}</h6>
            {{-- <div class="d-flex justify-content-evenly w-75">
              <div>
                <strong>Bookings:</strong>
                <p class="text-center">2</p>
              </div>
              <div>
                <strong>Rating:</strong>
                <p class="text-center">4.5/5</p>
              </div>
            </div> --}}
            @if (is_null(Auth::user()->faceIdPath))
              <a href="{{ route('user.activateAccount') }}" class="custom-btn custom-btn-dark">Activate your account</a>
            @endif
          </div>
        </div>
      </div>
      <div class="col-8 gx-1">
        <div class="d-flex justify-content-between align-items-center">
          <h4>Profile</h4>
          <div class="col d-flex justify-content-end p-0 m-0 ">
            <button class="custom-btn custom-btn-dark" id="edit-btn">Edit</button>
            <button class="custom-btn custom-btn-disabled ms-2" data-bs-toggle="modal" data-bs-target="#exampleModal"
              disabled id="save-btn">Save</button>
          </div>
        </div>
        <hr>
        <form action="{{ route('user.editProfilePost') }}" method="POST" id="editform">
          @csrf
          <div class="row mb-2">
            <div class="col">
              <label for="">First Name</label>
              <input name="firstName" type="text" class="inputs" value="{{ Auth::user()->firstName }}" disabled>
              @error('firstName')
              <p style="color:red">{{ $message }}</p>
              @enderror
            </div>
            <div class="col">
              <label for="">Last Name</label>
              <input name="lastName" type="text" class="inputs" value="{{ Auth::user()->lastName }}" disabled>
              @error('lastName')
              <p style="color:red">{{ $message }}</p>
              @enderror
            </div>
          </div>
          <div class="row mb-2">
            <div class="col">
              <label for="">Email</label>
              <input name="email" type="Email" class="inputs" disabled value="{{ Auth::user()->email }}">
              @error('email')
              <p style="color:red">{{ $message }}</p>
              @enderror
            </div>
            <div class="col">
              <label for="">Phone number</label>
              <input name="phone" type="text" maxlength="10" class="inputs" disabled
                value="{{ Auth::user()->phoneNumber }}" onkeypress="return isNumber(event)">
              @error('phone')
              <p style="color:red">{{ $message }}</p>
              @enderror
            </div>
          </div>
          <div class="row mb-2">
            <div class="col">
              <label for="">Birth date</label>
              <input name="birthDate" type="date" class="inputs" disabled value="{{ Auth::user()->birthDate }}">
              @error('birthDate')
              <p style="color:red">{{ $message }}</p>
              @enderror
            </div>
            <div class="col">
              <label for="address">Address</label>
              <input name="address" type="text" class="inputs" disabled value="{{ Auth::user()->address }}">
              @error('address')
              <p style="color:red">{{ $message }}</p>
              @enderror
            </div>
          </div>
          <div class="mt-4">
            <h4>change password</h4>
            <hr>
          </div>
          <div class="row mb-2">
            <div class="col">
              <label for="">New Password</label>
              <input name="password" type="Password" class="inputs" disabled>
              @error('password')
              <p style="color:red">{{ $message }}</p>
              @enderror
            </div>
            <div class="col">
              <label for="">Confirm Password</label>
              <input name="passwordConfirm" type="Password" class="inputs" disabled>
              @error('passwordConfirm')
              <p style="color:red">{{ $message }}</p>
              @enderror
            </div>
          </div>
        </form>
      </div>
    </div>
    <div class="white-space"></div>
  </div>
</div>
@endsection

@section('script')
{{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.js"
  integrity="sha512-n/4gHW3atM3QqRcbCn6ewmpxcLAHGaDjpEBu4xZd47N0W2oQ+6q7oc3PXstrJYXcbNU1OHdQ1T7pAP+gi5Yu8g=="
  crossorigin="anonymous" referrerpolicy="no-referrer"></script> --}}
<script>
  let inputs = document.querySelectorAll('.inputs');
  let editBtn = document.querySelector('#edit-btn');
  let saveBtn = document.querySelector('#save-btn');
    editBtn.addEventListener('click',e=>{
        e.preventDefault();
        inputs.forEach(e=>{
          e.disabled=false
        });
        editBtn.disabled = true;
        saveBtn.classList.add('custom-btn-disabled');
        saveBtn.disabled  = false;
        saveBtn.classList.remove('custom-btn-disabled');
        saveBtn.classList.add('custom-btn-success');
    })
    function isNumber(evt) {
      evt = (evt) ? evt : window.event;
      var charCode = (evt.which) ? evt.which : evt.keyCode;
        if (charCode > 31 && (charCode < 48 || charCode > 57)) {
          return false;
        }
  return true;
}


const inputfield = document.querySelector('#curpw')
const editform = document.querySelector('#editform')
const errorspan = document.querySelector('#errorspan')
$("#confirm").click(function(){
    $.ajax({
    type: "POST",
    dataType: "json",
    url: "checkPassword",
    data: {'_token': $('meta[name="_token"]').attr('content'),'password': inputfield.value},
    success: function(data){
        if(data.success){
            editform.submit();
        }else{
            errorspan.textContent="Wrong password"
            inputfield.value=""
        }
    }
  });
})

</script>

<script>
  document.querySelectorAll('.image-selector-open').forEach((e)=>{
      e.addEventListener('click',(ev)=>{
        ev.preventDefault();
        document.querySelector('#image-input').click();
      })
    })
var $modal = $('#modal');
var image = document.getElementById('image');
var cropper;

$("body").on("change", ".image", function(e){
    var files = e.target.files;
    var done = function (url) {
      image.src = url;
      $modal.modal('show');
    };
    var reader;
    var file;
    var url;

    if (files && files.length > 0) {
      file = files[0];

      if (URL) {
        done(URL.createObjectURL(file));
      } else if (FileReader) {
        reader = new FileReader();
        reader.onload = function (e) {
          done(reader.result);
        };
        reader.readAsDataURL(file);
      }
    }
});

$modal.on('shown.bs.modal', function () {
    cropper = new Cropper(image, {
      aspectRatio: 1,
      viewMode: 3,
      preview: '.preview',
      viewMode: 1
    });
}).on('hidden.bs.modal', function () {
    cropper.destroy();
    cropper = null;
});

$("#crop").click(function(){
    canvas = cropper.getCroppedCanvas({
        width: 160,
        height: 160,
      });

    canvas.toBlob(function(blob) {
    url = URL.createObjectURL(blob);
    var reader = new FileReader();
      reader.readAsDataURL(blob);
      reader.onloadend = function() {
        var base64data = reader.result;

        $.ajax({
        type: "POST",
        dataType: "json",
        url: "changeImage",
        data: {'_token': $('meta[name="_token"]').attr('content'), 'image': base64data},
        success: function(data){
            $modal.modal('hide');
            document.querySelector('#alert').style.display="block"
        }
      });
      }
    });
})

</script>

@endsection
@section('head')
<link rel="stylesheet" href="{{ asset('css/app.css') }}">
<meta name="_token" content="{{ csrf_token() }}">
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.js"
  integrity="sha256-WpOohJOqMqqyKL9FccASB9O0KwACQJpFTUBLTYOVvVU=" crossorigin="anonymous"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.4.1/css/bootstrap.min.css"
  crossorigin="anonymous" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.4.1/js/bootstrap.min.js"
  integrity="sha256-WqU1JavFxSAMcLP2WIOI+GB2zWmShMI82mTpLDcqFUg=" crossorigin="anonymous"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.6/cropper.css"
  integrity="sha256-jKV9n9bkk/CTP8zbtEtnKaKf+ehRovOYeKoyfthwbC8=" crossorigin="anonymous" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.6/cropper.js"
  integrity="sha256-CgvH7sz3tHhkiVKh05kSUgG97YtzYNnWt6OXcmYzqHY=" crossorigin="anonymous"></script>
@endsection
