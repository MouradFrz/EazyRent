<!DOCTYPE html>
<html lang="en">

<head>
    <meta name="_token" content="{{ csrf_token() }}">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link href="{{ asset('css/bootstrap.css') }}" rel="stylesheet">
    <title>Face Recognition</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            width: 100vw;
            height: 100vh;
            display: flex;

            align-items: center;
            flex-direction: column;
        }

        .btn-place {
            display: flex;
            width: 100%;
            align-items: center;
            flex-direction: column;
            justify-content: center;
            height: 300px;
        }

        canvas {
            position: absolute;
        }
    </style>

</head>

<body style="background-image: url('{{ asset('/images/dashboard/dashboard.jpg') }}');background-size:cover;">
    <div class="btn-place">
        <button id="button1" class="custom-btn custom-btn-dark" style="cursor: pointer;" onclick="startFace()">Start face
            ID</button>
        <button id="button2" class="custom-btn custom-btn-dark" style="cursor: pointer;display: none ;"
            onclick="restart()">Restart</button>
        <div class="alert m-5 " id="verificationError" role="alert">

        </div>
        <a href="{{ route('user.home') }}" id="home" class="custom-btn custom-btn-dark" style="display: none">Back to homepage</a>
    </div>


    <div class="display-cover">
        <video id="webCam" width="460" height="380" autoplay></video>
        <canvas id="canvas" class="d-none"></canvas>
    </div>
</body>

</html>

<script src="{{ asset('js/face-api.min.js') }}"></script>
<script src="https://unpkg.com/webcam-easy@1.0.5/dist/webcam-easy.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.js"
  integrity="sha256-WpOohJOqMqqyKL9FccASB9O0KwACQJpFTUBLTYOVvVU=" crossorigin="anonymous"></script>
<script>
    var video = document.querySelector("#webCam");
    var canvas = document.querySelector("#canvas");
    var btn1 = document.getElementById("button1");
    var btn2 = document.getElementById("button2");
    var error = document.getElementById("verificationError");
    var home = document.getElementById("home");
    let countInvalid = 0;
    let bookingID = '{!! $bookingID !!}';
    console.log(bookingID)
    function startFace() {
        btn1.style.display = 'none'
        if (navigator.mediaDevices.getUserMedia) {
            navigator.mediaDevices.getUserMedia({
                    video: true
                })
                .then(function(stream) {
                    video.srcObject = stream;
                })
                .catch(function(err0r) {
                    console.log("Something went wrong!");
                });
        }
        error.classList.remove('alert-danger')
        error.classList.remove('alert-success')
        error.classList.add('alert-secondary')
        error.textContent = 'Loading...'
        Promise.all([
            faceapi.nets.faceRecognitionNet.loadFromUri('/models'),
            faceapi.nets.faceLandmark68Net.loadFromUri('/models'),
            faceapi.nets.ssdMobilenetv1.loadFromUri('/models') //heavier/accurate version of tiny face detector
        ]).then(startIt)

        function startIt() {

            recognizeFaces()
        }
        let resultat = [];
        async function recognizeFaces() {
            const labeledDescriptors = await loadLabeledImages()
            const faceMatcher = new faceapi.FaceMatcher(labeledDescriptors, 0.56)
            const canvas = faceapi.createCanvasFromMedia(video)
            document.body.append(canvas)
            const displaySize = {
                width: video.width,
                height: video.height
            }
            faceapi.matchDimensions(canvas, displaySize)
            let counter = 0
            const intero = setInterval(async () => {
                const detections = await faceapi.detectAllFaces(video).withFaceLandmarks()
                    .withFaceDescriptors()

                const resizedDetections = faceapi.resizeResults(detections, displaySize)

                canvas.getContext('2d').clearRect(0, 0, canvas.width, canvas.height)

                const results = resizedDetections.map((d) => {
                    return faceMatcher.findBestMatch(d.descriptor)
                })
                if (results.length == 0) {
                    error.classList.remove('alert-secondary')
                    error.classList.remove('alert-succes')
                    error.classList.add('alert-danger')
                    error.textContent = 'Please keep your face visible for the camera'
                } else {
                    results.forEach((result, i) => {

                        const box = resizedDetections[i].detection.box
                        const drawBox = new faceapi.draw.DrawBox(box, {
                            label: result.toString()
                        })
                        resultat.push(results[0]._distance)
                        error.classList.remove('alert-secondary')
                        error.classList.remove('alert-danger')
                        error.classList.add('alert-success')
                        // error.textContent = 'Recognizing...'

                        if (results[0]._distance <= 0.56) {
                            counter++;
                        }
                        console.log(counter)
                    })
                }
                if (resultat.length == 10) {
                    const videoo = document.querySelector('video');
                    const mediaStream = videoo.srcObject;
                    const tracks = mediaStream.getTracks();
                    tracks[0].stop();
                    clearInterval(intero)
                    video.style.display = 'none'
                    canvas.style.display = 'none'
                    console.log(resultat)
                    if (counter >= 7) {
                        error.classList.remove('alert-secondary')
                        error.classList.remove('alert-danger')
                        error.classList.add('alert-success')
                        error.textContent = 'Face recognized! Your car is unlocked. Have a fun ride'
                        $.ajax({
                                type: "POST",
                                dataType: "json",
                                url: "http://localhost:8000/user/setGoing",
                                data: {
                                    '_token': $('meta[name="_token"]').attr('content'),
                                    'bookingID': bookingID
                                },
                                success: function(data) {
                                    home.style.display='block'
                                }
                            });
                    } else {
                        error.classList.remove('alert-secondary')
                        error.classList.remove('alert-succes')
                        error.classList.add('alert-danger')
                        error.textContent = 'Face not verified'
                        countInvalid++;
                        if (countInvalid == 3) {
                            error.classList.remove('alert-secondary')
                            error.classList.remove('alert-succes')
                            error.classList.add('alert-danger')
                            error.textContent =
                                'Your face is not recognised, please contact the secretary for more information'
                                $.ajax({
                                type: "POST",
                                dataType: "json",
                                url: "http://localhost:8000/user/setFailed",
                                data: {
                                    '_token': $('meta[name="_token"]').attr('content'),
                                    'bookingID': bookingID
                                },
                                success: function(data) {
                                    home.style.display='block'
                                }
                            });
                           
                        } else {
                            btn2.style.display = 'block'
                        }
                    }
                }
            }, 500)
        }

        function loadLabeledImages() {
            const labels = ['{!! Auth::user()->firstName !!} {!! Auth::user()->lastName !!} '] // for WebCam
            return Promise.all(
                labels.map(async (label) => {
                    const descriptions = []
                    for (let i = 1; i <= 4; i++) {
                        const img = await faceapi.fetchImage(
                            `../../images/users/faceidImages/{!! Auth::user()->username !!}_faceId.jpg`)
                        const detections = await faceapi.detectSingleFace(img).withFaceLandmarks()
                            .withFaceDescriptor()
                        descriptions.push(detections.descriptor)
                    }
                    console.log(label + ' Faces Loaded | ')
                    return new faceapi.LabeledFaceDescriptors(label, descriptions)
                })
            )
        }
    }

    function restart() {
        startFace()
        video.style.display = 'block'
        btn2.style.display = 'none'
    }
</script>
@section('scripts')
    <script src="https://unpkg.com/webcam-easy@1.0.5/dist/webcam-easy.min.js"></script>
    <script src="{{ asset('js/faceScript.js') }}"></script>
    <script src="{{ asset('js/face-api.min.js') }}"></script>
    
@endsection
