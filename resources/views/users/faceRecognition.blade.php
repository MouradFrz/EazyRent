<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <title>Face Recognition</title>
    <style>
        
        body {
            margin: 0;
            padding: 0;
            width: 100vw;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
        }
        canvas{
            position: absolute;
        }
       
    </style>
    
</head>
<body style="background-image: url('{{ asset('/images/dashboard/dashboard.jpg')}}')">
    <button id="button1"  onclick="startFace()">Start face ID</button>
    <button id="button2" style="display: none ; margin-top:600px" onclick="restart()">Restart</button>
   
        <span id="verificationError"></span>
      
        <div class="display-cover">
            <video id="webCam" width="460" height="380" autoplay></video>
            <canvas class="d-none"></canvas>
</body>
</html>
<script src="{{ asset('js/face-api.min.js') }}"></script>
<script src="https://unpkg.com/webcam-easy@1.0.5/dist/webcam-easy.min.js"></script>
<script>
    
    var video = document.querySelector("#webCam");
    var btn1 = document.getElementById("button1");
    var btn2 = document.getElementById("button2");
    var error = document.getElementById("verificationError");
    let countInvalid = 0;

    
    function startFace(){

        btn1.style.display='none'

if (navigator.mediaDevices.getUserMedia) {
  navigator.mediaDevices.getUserMedia({ video: true })
    .then(function (stream) {
      video.srcObject = stream;
    })
    .catch(function (err0r) {
      console.log("Something went wrong!");
    });
}

Promise.all([
    faceapi.nets.faceRecognitionNet.loadFromUri('/models'),
    faceapi.nets.faceLandmark68Net.loadFromUri('/models'),
    faceapi.nets.ssdMobilenetv1.loadFromUri('/models') //heavier/accurate version of tiny face detector
]).then(startIt)

function startIt() {
    console.log('Models Loaded')
    recognizeFaces()
}
let resultat =[];
async function recognizeFaces() {

    const labeledDescriptors = await loadLabeledImages()
    console.log(labeledDescriptors)
    const faceMatcher = new faceapi.FaceMatcher(labeledDescriptors, 0.56)


    console.log(faceMatcher)
        const canvas = faceapi.createCanvasFromMedia(video)
        document.body.append(canvas)

        const displaySize = { width: video.width, height: video.height }
        faceapi.matchDimensions(canvas, displaySize)

        
        let counter = 0
        const intero = setInterval(async () => {
            const detections = await faceapi.detectAllFaces(video).withFaceLandmarks().withFaceDescriptors()

            const resizedDetections = faceapi.resizeResults(detections, displaySize)

            canvas.getContext('2d').clearRect(0, 0, canvas.width, canvas.height)
            
            const results = resizedDetections.map((d) => {
                return faceMatcher.findBestMatch(d.descriptor)
            })
            
            results.forEach( (result, i) => {
               
                const box = resizedDetections[i].detection.box
                const drawBox = new faceapi.draw.DrawBox(box, { label: result.toString() })
                resultat.push(results[0]._distance)
                console.log(results[0]._distance)
                
                if(results[0]._distance <= 0.56 ) {
                    counter++;
                }
                console.log(counter)

            })
            
            if(resultat.length == 10){
                clearInterval(intero)
                video.style.display='none'
                console.log(resultat)
                if(counter >= 7){
                    error.textContent='Face Verified!'
                    
                }
                else{

                    error.textContent='Face not verified'
                    countInvalid++;
                    if(countInvalid == 3){
                    error.textContent='Your face is not recognised, please contact the secretary for more information'
                    }
                    else{
                        btn2.style.display='block'
                    }
                    
                   
                }                
            }
        }, 500)
 
}




function loadLabeledImages() {
   
    const labels = ['{!! Auth::user()->firstName!!} {!! Auth::user()->lastName!!} '] // for WebCam
    return Promise.all(
        labels.map(async (label)=>{
            const descriptions = []
            for(let i=1; i<=4; i++) {
                const img = await faceapi.fetchImage(`../images/users/faceidImages/{!! Auth::user()->username !!}_faceId.jpg`)
                const detections = await faceapi.detectSingleFace(img).withFaceLandmarks().withFaceDescriptor()
                descriptions.push(detections.descriptor)
            }
            console.log(label+' Faces Loaded | ')
            return new faceapi.LabeledFaceDescriptors(label, descriptions)
        })
    )
}
// function startFace() {
// var x = document.getElementById("webCam");

// if (x.style.display === "none") {
// x.style.display = "block";

// } else {
// x.style.display = "none";
// }
// } 
}
function restart() {
    startFace()
    video.style.display='block'
    btn2.style.display='none'
} 



</script>
@section('scripts')
<script  src="https://unpkg.com/webcam-easy@1.0.5/dist/webcam-easy.min.js"></script>
<script  src="{{ asset('js/faceScript.js') }}"></script>
<script  src="{{ asset('js/face-api.min.js') }}"></script>

@endsection
