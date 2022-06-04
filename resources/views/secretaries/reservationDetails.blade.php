@extends('layouts.workerLayout')

@section('headTags')
<link rel="stylesheet" href="{{asset('css/secretary/index.css')}}">
{{-- <script>
  function imageZoom(imgID, resultID) {
    var img, lens, result, cx, cy;
    img = document.getElementById(imgID);
    result = document.getElementById(resultID);
    /*create lens:*/
    lens = document.createElement("DIV");
    lens.setAttribute("class", "img-zoom-lens");
    /*insert lens:*/
    img.parentElement.insertBefore(lens, img);
    /*calculate the ratio between result DIV and lens:*/
    cx = result.offsetWidth / lens.offsetWidth;
    cy = result.offsetHeight / lens.offsetHeight;
    /*set background properties for the result DIV:*/
    result.style.backgroundImage = "url('" + img.src + "')";
    result.style.backgroundSize = (img.width * cx) + "px " + (img.height * cy) + "px";
    /*execute a function when someone moves the cursor over the image, or the lens:*/
    lens.addEventListener("mouseenter", moveLens);
    img.addEventListener("mouseenter", moveLens);

    img.addEventListener("mouseleave", removeResult)
    /*and also for touch screens:*/
    lens.addEventListener("touchmove", moveLens);
    img.addEventListener("touchmove", moveLens);
    function removeResult(e) {
      result.classList.add('d-none')
    }
    function moveLens(e) {
      result.classList.remove('d-none')
      var pos, x, y;
      /*prevent any other actions that may occur when moving over the image:*/
      e.preventDefault();
      /*get the cursor's x and y positions:*/
      pos = getCursorPos(e);
      /*calculate the position of the lens:*/
      x = pos.x - (lens.offsetWidth / 2);
      y = pos.y - (lens.offsetHeight / 2);
      /*prevent the lens from being positioned outside the image:*/
      if (x > img.width - lens.offsetWidth) {x = img.width - lens.offsetWidth;}
      if (x < 0) {x = 0;}
      if (y > img.height - lens.offsetHeight) {y = img.height - lens.offsetHeight;}
      if (y < 0) {y = 0;}
      /*set the position of the lens:*/
      lens.style.left = x + "px";
      lens.style.top = y + "px";
      /*display what the lens "sees":*/
      result.style.backgroundPosition = "-" + (x * cx) + "px -" + (y * cy) + "px";
    }
    function getCursorPos(e) {
      var a, x = 0, y = 0;
      e = e || window.event;
      /*get the x and y positions of the image:*/
      a = img.getBoundingClientRect();
      /*calculate the cursor's x and y coordinates, relative to the image:*/
      x = e.pageX - a.left;
      y = e.pageY - a.top;
      /*consider any page scrolling:*/
      x = x - window.pageXOffset;
      y = y - window.pageYOffset;
      return {x : x, y : y};
    }
  }
</script> --}}
@endsection

@section('content')
<div class="reservation details">
  <div class="container">
    @if (Session::get('fail'))
    <div class="alert alert-danger alert-dismissible fade show w-100" role="alert">
      <strong>{{ Session::get('fail') }}</strong>
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif
    @if (Session::get('success'))
    <div class="alert alert-success alert-dismissible fade show w-100 " role="alert">
      <strong>{{ Session::get('success') }}</strong>
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif
    <h2 class="section-header">Reservation details</h2>
    <div class="row">
      <div class="col">
        <h3>client informations</h3>
        <p class="label">Full name:</p>
        <p class="value">{{ $booking->firstName }} {{ $booking->lastName }}</p>
        <p class="label">birthdate</p>
        <p class="value">{{$booking -> birthDate}}</p>
        <p class="label">Ban count:</p>
        <p class="value">
          @if($booking->nbBan == 0 )
          No bans
          @else
          {{ $booking->nbBan }}
          @endif
        </p>
        <p class="label">Identity card number</p>
        <p class="value">{{$booking -> idCard}}</p>
        <p class="label">Identity card image:</p>
        {{-- <div class="img-zoom-container"> --}}
          <img id="IdCardImage" class="id-card-image"
            src="{{ asset('images/users/idCardImages/'. $booking->idCardPath) }}" alt="{{$booking -> idCard}}">
          {{-- <div id="hoverResult" class="img-zoom-result d-none"></div>
        </div> --}}
      </div>
      <div class="col">
        <h3>contact info</h3>
        <p class="label">Email:</p>
        <p class="value">{{ $booking->email }}</p>
        <p class="label">Phone number:</p>
        <p class="value">
          @if(!is_null($booking->phoneNumber))
          {{ $booking->phoneNumber }}
          @else
          Unavailable
          @endif
        </p>
      </div>
    </div>
    <hr>
    <div class="row">
      <div class="col">
        <h4>Car information:</h4>
        <p class="label">Car plate number</p>
        <p class="value">{{ $booking->plateNb }}</p>
        <p class="label">Car model:</p>
        <p class="value">{{ $booking->brand }} {{ $booking->model }}</p>
        <p class="label">Price:</p>
        <p class="value"> {{ $booking->pricePerDay }}DA/day, {{ $booking->pricePerHour }}DA/hour</p>
        <p class="label">Current garage address:</p>
        <p class="value">{{ $booking->address }}</p>
      </div>
      <div class="col">
        <h4>Booking information:</h4>
        <p class="label">Pick-up location:</p>
        <p class="value">{{ $booking->pickUpLocation }}</p>
        <p class="label">Drop-off location:</p>
        <p class="value">{{ $booking->dropOffLocation }}</p>
        <p class="label">Pick-up date:</p>
        <p class="value">{{ $booking->pickUpDate }}</p>
        <p class="label">Drop-off date:</p>
        <p class="value">{{ $booking->dropOffDate }}</p>
        <p class="label">Payement method:</p>
        <p class="value">{{ $booking->payementMethod }}</p>
        <p class="label">Duration:</p>
        <p class="value">{{ $interval }} </p>
        <p class="label">Reservation sent at:</p>
        <p class="value">{{ $booking->created_at }} </p>
      </div>
    </div>
    <div class="d-flex action">
      @if($booking->state=="REQUESTED")
      <form action="{{route('secretary.acceptBooking',$booking->bookingID)}}" method="POST" id="accept">@csrf</form>
      <button class="btn btn-primary" onclick="document.querySelector('#accept').submit()">Accept booking
        request</button>
      <button class="btn btn-danger ms-2" data-bs-toggle="modal" data-bs-target="#declineBooking">Decline
        booking request</button>

      @elseif($booking->state=="DECLINED")
      <p style="color: red;display:block">You declined this request </p><br>
      <p class="label">Decline reason:</p>

      <p class="value">{{ $booking->declineReason }}</p>
      @else
      <p>You accepted this request at {{ $booking->updated_at }}</p>
      @endif
      <div class="modal fade" id="declineBooking" tabindex="-1" aria-labelledby="declineBookingLabel"
        aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="declineBookingLabel">decline booking request</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{route('secretary.declineBooking', $booking->bookingID )}}" method="post">
              @csrf
              <div class="modal-body">
                <label for="decline-reason" class="form-label">decline reason</label>
                <input type="text" name="declineReason" class="form-control">
                <div class="form-text">this step cannot be reversed</div>
                <span class="text-danger">
                  @error('declineReason')
                  {{ $message }}
                  @enderror
                </span>
              </div>
              <div class="modal-footer">
                <button type="submit" class="btn btn-danger">decline booking</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection

@section('scripts')
<script>
  console.log(JSON.parse('@json($booking)'))
</script>
<script>
  imageZoom("IdCardImage", "hoverResult");
</script>

@endsection
