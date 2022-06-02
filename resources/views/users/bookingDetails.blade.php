@extends('layouts.userLayout')


@section('content')
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Sign this contract</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form action="{{ route('user.signContract',$booking->bookingID) }}" method="POST" id="form">
            @csrf
            <label for="">Enter your password</label>
            <input type="password" name="password" class="form-control"> <br>
            <input type="checkbox" name="valid" id="">
            <span>I have read the contract and i agree on signing it.</span>
            <br>
            <small class="text-muted">THIS STEP IS IRREVERSIBLE</small>
          </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="button" class="btn btn-primary" onclick="document.querySelector('#form').submit()">SIGN</button>
        </div>
      </div>
    </div>
  </div>
  <div class="modal fade" id="declineModal" tabindex="-1" aria-labelledby="declineModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Decline this contract</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form action="{{ route('user.declineContract',$booking->bookingID) }}" method="POST" id="form1">
            @csrf
            <label for="">Enter your password</label>
            <input type="password" name="password" class="form-control"> <br>
            <input type="checkbox" name="valid" id="">
            <span>I have read the contract and i want to cancel it.</span>
            <br>
            <small class="text-muted">THIS STEP IS IRREVERSIBLE</small>
          </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="button" class="btn btn-warning" onclick="document.querySelector('#form1').submit()">DECLINE CONTRACT</button>
        </div>
      </div>
    </div>
  </div>
    <div>
        <div class="container">
            @if(Session::get('success'))
            <div class="alert alert-success w-100" role="alert">
                {{ Session::get('success') }}
                <br> You have all the neccessary in the contract file.
            </div>
            @endif
            @if(Session::get('declined'))
            <div class="alert alert-warning w-100" role="alert">
                {{ Session::get('declined') }}
                
            </div>
            @endif
            @error('password')
            <div class="alert alert-danger w-100" role="alert">
                {{ $message }}
                </div>
            @enderror
            @error('valid')
            <div class="alert alert-danger w-100" role="alert">
                {{ $message }}
                </div>
            @enderror
            @if ($booking->state=="REQUESTED")
                <p>Your booking is being processed by the agency <br>
                    Please be paitient <br>
                    You will be notified when the agency responds

                   <span class="fw-bold"> Hacen hna affichi les details ta3 l booking b had l variable</span>  <br> {{ $booking }}
                </p>
            @elseif($booking->state=="DECLINED")
            <p>This booking has been refused by the agency <br>

                Reason :<br>
                {{ $booking->declineReason }}
        

               <span class="fw-bold"> Hacen hna affichi les details ta3 l booking b had l variable</span>  <br> {{ $booking }}
            </p>
            @else
            <h1>Contract</h1>
            <div class="d-flex justify-content-center" >
                <canvas id="the-canvas" style="border: 1px solid red; max-width:800px"></canvas>
            </div>
            @endif
            <div class="d-flex justify-content-center ">
                @if ($booking->state=="ACCEPTED")
                <button class="btn btn-warning m-2 " data-bs-toggle="modal" data-bs-target="#declineModal">Cancel contract</button>
                <a href="{{ route('user.downloadPdf',$booking->bookingID) }}" class="btn btn-primary m-2">Download Contract</a>
                <button class="btn btn-success m-2" data-bs-toggle="modal" data-bs-target="#exampleModal">Sign contract</button>
                
                @elseif($booking->state=="SIGNED" || $booking->state=="ON GOING" || $booking->state=="FINISHED")
                <a href="{{ route('user.downloadPdf',$booking->bookingID) }}" class="btn btn-primary m-2">Download Contract</a>
                @elseif($booking->state=="CANCELED")
                <p>You canceled this contract.</p>
                @endif
               
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script src="https://mozilla.github.io/pdf.js/build/pdf.js"></script>
    {{-- <script>

        let booking = {!! json_encode($booking, JSON_HEX_TAG) !!}
        pdfjsLib.GlobalWorkerOptions.workerSrc = '//mozilla.github.io/pdf.js/build/pdf.worker.js';
        pdfjsLib.getDocument(`/contracts/contract_${booking.bookingID}.pdf`).promise.then(doc=>{
            doc.getPage(1).then(page=>{

                let canvas = document.querySelector('#myCanvas')
                let context = canvas.getContext("2d")
        
                let viewport = page.getViewport()
                console.log(page)
                canvas.width = viewport.width;
                canvas.height = viewport.height;

                page.render({
                    canvasContext : context,
                    viewport
                })
            })
        })
    </script> --}}

    <script>

let booking = {!! json_encode($booking, JSON_HEX_TAG) !!}
var url = `/contracts/contract_${booking.bookingID}.pdf`;

var pdfjsLib = window['pdfjs-dist/build/pdf'];


pdfjsLib.GlobalWorkerOptions.workerSrc = '//mozilla.github.io/pdf.js/build/pdf.worker.js';
var loadingTask = pdfjsLib.getDocument(url);
loadingTask.promise.then(function(pdf) {
  var pageNumber = 1;
  pdf.getPage(pageNumber).then(function(page) {
    var scale = 1.5;
    var viewport = page.getViewport({scale: scale});
    var canvas = document.getElementById('the-canvas');
    var context = canvas.getContext('2d');
    canvas.height = viewport.height;
    canvas.width = viewport.width;
    var renderContext = {
      canvasContext: context,
      viewport: viewport
    };
    var renderTask = page.render(renderContext);
    renderTask.promise.then(function () {
      console.log('Page rendered');
    });
});
}, function (reason) {
  console.error(reason);
});
    </script>
@endsection