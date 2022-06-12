@extends('layouts.workerLayout')
@section('headTags')
<link rel="stylesheet" href="{{asset('css/secretary/index.css')}}">
@endsection

@section('content')
@if(Session::get('message'))
<div class="alert alert-success w-100 " role="alert">
    {{ Session::get('message') }}
</div>
@endif

<div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="modalLabel">Crop your image</h5>
          <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
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
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
          <button type="button" class="btn btn-primary" id="crop">Change</button>
        </div>
      </div>
    </div>
  </div>




<div class="create-agency mt-5">
    <div class="container">
        <div class="alert alert-success w-100 " style="display: none" role="alert" id="alert">
            Your image has been changed successfully. Reload the page the view the change.
          </div>
      <h2>Profile </h2>
      <hr>
      <form method="POST" action="{{route('secretary.editProfile')}}" enctype="multipart/form-data">
        @csrf
        <div class="row">
            <div class="col d-flex flex-column">
            @if(!is_null(Auth::user()->profilePath))
            <img src="{{ asset('images/secretary/profile/'.Auth::user()->username).'_profile.png' }}" alt="" style="width: 150px;border-radius:50%;" class="image-change mb-3">
            <button class="custom-btn cus image-selector-open" style="width: 150px;">Change profile picture</button>
            @else
            <img src="{{ asset('images/download.png') }}" alt="" style="width: 150px;border-radius:50%;" class="image-change mb-3">
            <button class="btn btn-primary image-selector-open" style="width: 150px;"> Add profile picture</button>
            @endif
            <input type="file" name="image" class="image" style="display: none" id="image-input">
        </div>
        <div class="row">
            <div>

                <h5>{{ Auth::user()->firstName }} {{ Auth::user()->lastName }}</h5>
                <h6 class="text-muted fw-light">{{ Auth::user()->username }}</h6>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <label for="" class="form-label">Username</label>
                <input type="text" name="username" class="form-control" placeholder="Username" value="{{ Auth::user()->username }}" disabled>
                @error('username')
                    <p style="color:red">{{ $message }}</p>
                    @enderror
            </div>

        </div>
        <div class="row">
            <div class="col">
                <label for="" class="form-label">First name</label>
                <input type="text" name="firstName" class="form-control" placeholder="First name" value="{{ Auth::user()->firstName }}" disabled>
                @error('firstName')
                    <p style="color:red">{{ $message }}</p>
                    @enderror
            </div>
            <div class="col">
                <label for="" class="form-label">Last name</label>
                <input type="text" name="lastName" class="form-control" placeholder="Last name" value="{{ Auth::user()->lastName }}" disabled>
                @error('lastName')
                    <p style="color:red">{{ $message }}</p>
                    @enderror
            </div>
        </div>
        <div class="row">
            <div class="col">
                <label for="" class="form-label">Birth date</label>
                <input type="date" name="birthDate" class="form-control" placeholder="Birth date" value="{{ Auth::user()->birthDate }}" disabled>
                @error('birthDate')
                    <p style="color:red">{{ $message }}</p>
                    @enderror
            </div>
            <div class="col">
                <label for="" class="form-label">Email</label>
                <input type="text" name="email" class="form-control" placeholder="Email" value="{{ Auth::user()->email }}" disabled>
                @error('email')
                    <p style="color:red">{{ $message }}</p>
                    @enderror
            </div>
        </div>
        <div class="row">
            <div class="col">
                <label for="" class="form-label">Phone number</label>
                <input type="text" name="phone" class="form-control" maxlength="10" placeholder="Phone number" value="{{ Auth::user()->phoneNumber }}" disabled onkeypress="return isNumber(event)">
                @error('phone')
                    <p style="color:red">{{ $message }}</p>
                    @enderror
            </div>
            <div class="col">
                <label for="" class="form-label">Address</label>
                <input type="text" name="address" class="form-control" placeholder="Address" value="{{ Auth::user()->address }}" disabled>
                @error('address')
                    <p style="color:red">{{ $message }}</p>
                    @enderror
            </div>
        </div>
        <small class="text-muted ">Leave the new password field empty if you want to keep the same password. *</small>
        <div class="row">
            <div class="col">
                <label for="" class="form-label">New password</label>
                <input type="password" name="newPassword" class="form-control" placeholder="New password" value="" disabled>
                @error('newPassword')
                    <p style="color:red">{{ $message }}</p>
                    @enderror
            </div>
            <div class="col">
                <label for="" class="form-label">Confirm password</label>
                <input type="password" name="passwordConfirm" class="form-control" placeholder="Confirm password" value="" disabled>
                @error('passwordConfirm')
                    <p style="color:red">{{ $message }}</p>
                    @enderror
            </div>
        </div>
        <div class="row d-flex justify-content-end">
            <div class="col-6">
                <label for="" class="form-label">Current password</label>
                <input type="password" name="currentPassword" class="form-control" placeholder="Current password" value="" disabled>
                @error('currentPassword')
                    <p style="color:red">{{ $message }}</p>
                    @enderror
            </div>
        </div>
        <div class="row m-3">
            <div class="col d-flex justify-content-end p-0 m-0 gx-5">
                <button class="btn btn-primary" id="edit-btn">Edit</button>
               <button class="btn btn-success ms-3" type="submit" disabled id="save-btn">Save</button>
            </div>
        </div>
      </form>

    </div>
  </div>
@endsection

@section('scripts')
    <script>
        let inputs = document.querySelectorAll('.form-control');

        document.querySelector('#edit-btn').addEventListener('click',e=>{
            e.preventDefault();
            inputs.forEach(e=>{
                e.disabled=false;
            });
            document.querySelector('#save-btn').disabled=false;
        })

        function isNumber(evt) {
          evt = (evt) ? evt : window.event;
          var charCode = (evt.which) ? evt.which : evt.keyCode;
            if (charCode > 31 && (charCode < 48 || charCode > 57)) {
              return false;
            }
    return true;
}

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
                viewMode: 2
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
@section('headTags')
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('css/secretary/index.css') }}">
    <meta name="_token" content="{{ csrf_token() }}">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.js" integrity="sha256-WpOohJOqMqqyKL9FccASB9O0KwACQJpFTUBLTYOVvVU=" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.4.1/css/bootstrap.min.css" crossorigin="anonymous" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha256-WqU1JavFxSAMcLP2WIOI+GB2zWmShMI82mTpLDcqFUg=" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.6/cropper.css" integrity="sha256-jKV9n9bkk/CTP8zbtEtnKaKf+ehRovOYeKoyfthwbC8=" crossorigin="anonymous" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.6/cropper.js" integrity="sha256-CgvH7sz3tHhkiVKh05kSUgG97YtzYNnWt6OXcmYzqHY=" crossorigin="anonymous"></script>
@endsection
