@extends('layouts.userLayout')
@section('head')
    <style>
        #my_camera {
            width: 480px;
            height: 360px;
            border: 1px solid black;
        }
    </style>
    <meta name="_token" content="{{ csrf_token() }}">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.js"
        integrity="sha256-WpOohJOqMqqyKL9FccASB9O0KwACQJpFTUBLTYOVvVU=" crossorigin="anonymous"></script>
@endsection

@section('content')
    <div>
        <div class="container">
            <h2>Account activation</h2>
            <p>In order to activate your account, We need to scan your facial features.
                <br>
                This is necessary to validate your identity when picking up a booked vehicle.
                <br>
                To start the scan, click on "Start scanning".
            </p>
            <div class="d-flex w-100 flex-column justify-content-center align-items-center">
                <div class="alert m-5 " id="verificationError" role="alert">
                    
                </div>
                <input type=button value="Start scanning" id="startbtn" onClick="startScan()" class="m-3 custom-btn custom-btn-dark">
                <div id="my_camera"></div>
                
            </div>
        </div>
    </div>
    

    <div id="results"></div>
@endsection




@section('script')
    <script type="text/javascript" src="{{ asset('js/webcam.min.js') }}"></script>
    <script src="{{ asset('js/face-api.min.js') }}"></script>
    <script language="JavaScript">
        const startBtn=document.querySelector('#startbtn')
        const error=document.querySelector('#verificationError')
        error.style.display="none"
        Webcam.set({
            width: 480,
            height: 360,
            image_format: 'jpeg',
            jpeg_quality: 90
        });
        Webcam.attach('#my_camera');
        let counter = 0
        async function startScan() {
            Promise.all([
                faceapi.nets.ssdMobilenetv1.loadFromUri('/models')
            ]).then(() => {
                var intero = setInterval(async () => {
                    let base64image = ''
                    Webcam.snap(function(data_uri) {
                        base64image = data_uri;
                    });
                    let blob;
                    var url =
                        base64image
                    fetch(url)
                        .then(res => blob = res.blob()).then(async (res) => {
                            const image = await faceapi.bufferToImage(res)
                            const detections = await faceapi.detectAllFaces(image)
                            if (detections.length == 0) {
                                startBtn.style.display="none"
                                error.style.display="block"
                                error.classList.remove('alert-danger')
                                error.classList.remove('alert-success')
                                error.classList.add('alert-secondary')
                                error.textContent = 'Please keep your face visible for the camera'
                            } else {
                                error.style.display="block"
                                error.classList.remove('alert-danger')
                                error.classList.remove('alert-secondary')
                                error.classList.add('alert-success')
                                error.textContent = 'Recognizing...'
                                $.ajax({
                                    type: "POST",
                                    dataType: "json",
                                    url: "http://localhost:8000/user/upload",
                                    data: {
                                        '_token': $('meta[name="_token"]').attr(
                                            'content'),
                                        'image': base64image,
                                        'counter': counter + 1
                                    },
                                    success: function(data) {
                                        counter = counter + 1
                                        if (counter == 5) {
                                            clearInterval(intero);
                                            counter = 0
                                            $.ajax({
                                                type: "POST",
                                                dataType: "json",
                                                url: 'http://localhost:8000/user/setActive',
                                                data: {
                                                    '_token': $(
                                                        'meta[name="_token"]'
                                                    ).attr(
                                                        'content'),
                                                },
                                                success: function() {
                                                    error.classList.remove('alert-danger')
                                                    error.classList.remove('alert-secondary')
                                                    error.classList.add('alert-success')
                                                    error.textContent = 'Your account is now activated!'
                                                    document.querySelector('#my_camera').style.display="none"
                                                }
                                            })
                                        }
                                    }
                                });
                            }
                        })
                }, 1000);
            })
        }
    </script>


    {{-- <script src="{{ asset('js/face-api.min.js') }}"></script>
    <script>
        var video = document.querySelector("#webCam");
        var canvas = document.querySelector("#canvas");


        const models_uri = ""
        Promise.all([
            faceapi.nets.ssdMobilenetv1.loadFromUri('/models')
        ]).then(start)
        async function start() {

            const canvas = faceapi.createCanvasFromMedia(video)
            document.body.append(canvas)
            const displaySize = {
                width: video.width,
                height: video.height
            }

            const image = await faceapi.bufferToImage(imageUpload.files[0])
            const detections = await faceapi.detectAllFaces(image)



            if (detections.length == 1) {
                verification.textContent = "Your image is valid"
                verification.style.color = "green"
                submitButton.disabled = false
            } else {
                verification.textContent = "Your image invalid, please choose a more clear picture"
                verification.style.color = "red"
                submitButton.disabled = true
            }
        }

        // start() --}}
    {{-- </script> --}}
    <script></script>
@endsection
