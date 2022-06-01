@extends('layouts.userLayout')


@section('content')
    <div>
        <div class="container">
            
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
            <div class="d-flex justify-content-center">
                <canvas id="the-canvas"></canvas>
            </div>
            @endif
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