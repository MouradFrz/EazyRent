@extends('layouts.workerLayout')

@section('content')
<div class="modal fade" id="sendRating" tabindex="-1" aria-labelledby="sendRatingLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Rating a client</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <p>The user you are about to rate : <span id="userfullname" class="fw-bold"></span></p>
        <form action="{{ route('secretary.setRating') }}" method="POST" id="hello">
          @csrf

          <input type="text" name="bookingID" style="display: none" id="resID" class="form-control">
          <label for="">Mark (/5) </label>
          <input type="number" max="5" min="0" step="0.5" name="rating" class="form-control">
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="button" class="btn btn-success" onclick="document.querySelector('#hello').submit()">Confirm</button>
      </div>
    </div>
  </div>
</div>
<div class="modal fade" id="banUser" tabindex="-1" aria-labelledby="banUserLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Ban a client</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <p>Enter ban duration then confirm: </p>
        <form action="{{ route('secretary.banUser') }}" method="POST" id="ban">
          @csrf
          <input type="text" id="bannedUsername" name="username" style="display: none">
          <label for="">Concerned client:</label>
          <input type="text" disabled value="" id="bannedFullname" class="form-control">
          <label for="">Ban duration(Days):</label>
          <input type="number" name="duration" min="0" class="form-control"  value="">
          <label for="">Ban reason:</label>
          <textarea name="reason" id=""  ></textarea>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="button" class="btn btn-danger" onclick="document.querySelector('#ban').submit()">Confirm</button>
      </div>
    </div>
  </div>
</div>
<div>
    <div class="container">
      @if (Session::get('success'))
      <div class="alert alert-success alert-dismissible fade show w-100" role="alert">
        {{ Session::get('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>
     
      @endif
        <h2 class="my-3">History</h2>
        <hr>
        <table class="table table-striped" id="booktable">
            <thead>
              <tr>
                <th>Clients full name</th>
                <th>Plate number</th>
                <th>Reservation's state</th>
                <th>Request sent at</th>
                <th>Answered at</th>
                <th>Banned</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>
             
               @foreach ($bookings as $element)
               
              <tr>
                <td style="position: relative"><p class="fullname">{{ $element->firstName }} {{ $element->lastName }}</p>
                <div class="dropmenu"> 
                  <div class="drop-align">
                    @if(is_null($element->secretaryRatesClient))
                  <button class="btn btn-primary btn-sm ratingbtn"  data-bs-toggle="modal" data-bs-target="#sendRating" data-resID="{{ $element->bookingID }}" data-fullname="{{ $element->firstName }} {{ $element->lastName }}">Rate this user</button>
                  @else
                  <button class="btn btn-success disabled btn-sm" >Rated : {{ $element->secretaryRatesClient }}/5</button>
                  @endif
                  @if(count($secbans)!=0)
                    @foreach ($secbans as $ban)
                    @if($ban->bannedClient==$element->username)
                        @if($ban->endDate>now())  
                            <button class="btn btn-danger btn-sm" disabled>Banned</button>
                            @break
                        @endif
                        @if($ban->endDate<now())
                          <button class="btn btn-danger btn-sm banbtn" data-fullname="{{ $element->firstName }} {{ $element->lastName }}" data-un="{{ $element->username }}" data-bs-toggle="modal" data-bs-target="#banUser">Ban this user</button>
                          @break
                        @endif
                      @else
                        @if ($loop->index==count($secbans)-1)
                        <button class="btn btn-danger btn-sm banbtn" data-fullname="{{ $element->firstName }} {{ $element->lastName }}" data-un="{{ $element->username }}" data-bs-toggle="modal" data-bs-target="#banUser">Ban this user</button>
                        @else
                      @continue
                      @endif
                      @endif
                    @endforeach
                  @else
                    <button class="btn btn-danger btn-sm banbtn" data-fullname="{{ $element->firstName }} {{ $element->lastName }}" data-un="{{ $element->username }}" data-bs-toggle="modal" data-bs-target="#banUser">Ban this user</button>
                  @endif
                </div>
                </div>
              </td>
                <td>{{ $element->vehiculePlateNB }}</td>
                <td>{{ $element->state }}</td>
                <td>{{ $element->created_at }}</td>
                <td>{{ $element->updated_at }}</td>
                <td>
                  @foreach ($secbans as $ban)
                    @if($ban->bannedClient==$element->username)
                      @if ($ban->endDate>now())
                        YES 
                        @break
                    
                    @else
                    NO
                    @break
                    @endif
                    @endif
                  @endforeach
                </td>
                <td><a href="{{ route('secretary.reservationDetails',$element->bookingID) }}">View details</a></td>       
              </tr>
              @endforeach
            </tbody>
          
          </table>
          {{$bookings->links()}}
    </div>
  
</div>

@endsection

@section('headTags')
<link rel="stylesheet" href="https://cdn.datatables.net/1.12.0/css/jquery.dataTables.css">
<link rel="stylesheet" href="{{ asset('css/secretary/index.css') }}">
@endsection

@section('scripts')
<script src="https://code.jquery.com/jquery-3.6.0.slim.min.js" integrity="sha256-u7e5khyithlIdTpu22PHhENmPcRdFiHRjhAuHcs05RI=" crossorigin="anonymous"></script>
<script src="https://cdn.datatables.net/1.12.0/js/jquery.dataTables.min.js" crossorigin="anonymous"></script>
<script>
     let booktable = new DataTable('#booktable');
</script>

<script>
   const labels = document.querySelectorAll(".fullname");
const dropmenus = document.querySelectorAll(".dropmenu");

labels.forEach((e, i) => {
  e.addEventListener("click", () => {
    labels.forEach((es) => {
      es.classList.remove("show");
    });
    dropmenus.forEach((es) => {
      es.classList.remove("show");
    });
    e.classList.add("show");
    dropmenus[i].classList.add("show");
  });
});

dropmenus.forEach((e) => {
  e.addEventListener("mouseleave", () => {
    labels.forEach((es) => {
      es.classList.remove("show");
    });
    dropmenus.forEach((es) => {
      es.classList.remove("show");
    });
  });
});
const banbtns = document.querySelectorAll(".banbtn");
const ratingbtns = document.querySelectorAll(".ratingbtn");
const userfullname = document.querySelector("#userfullname");
const resId = document.querySelector("#resID");

console.log(ratingbtns[0]);
ratingbtns.forEach((e) => {
  e.addEventListener("click", () => {
    userfullname.textContent = e.dataset.fullname;
    resId.value = e.dataset.resid;
  });
});
banbtns.forEach((e) => {
  e.addEventListener("click", () => {
    document.querySelector("#bannedUsername").value = e.dataset.un;
    document.querySelector("#bannedFullname").value = e.dataset.fullname;
    console.log(document.querySelector("#bannedUsername").value);
    console.log(document.querySelector("#bannedFullname").value);
  });
});

</script>
@endsection

