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
<body>
    <button id="button1" onclick="startFace()">Start face ID</button>
    <p style="background-image:url('../images/dashboard/dashboard.jpeg')"></p>
    <video id="videoInput" width="460" height="380" style="display: none" muted controls>
</body>
</html>
<script src="{{ asset('js/face-api.min.js') }}"></script>
<script>
    const video = document.getElementById('videoInput')

Promise.all([
    faceapi.nets.faceRecognitionNet.loadFromUri('/models'),
    faceapi.nets.faceLandmark68Net.loadFromUri('/models'),
    faceapi.nets.ssdMobilenetv1.loadFromUri('/models') //heavier/accurate version of tiny face detector
]).then(start)

function start() {
    document.body.append('Models Loaded')
    
    navigator.getUserMedia(
        { video:{} },
        stream => video.srcObject = stream,
        err => console.error(err)
    )
    console.log('video added')
    recognizeFaces()
}

async function recognizeFaces() {

    const labeledDescriptors = await loadLabeledImages()
    console.log(labeledDescriptors)
    const faceMatcher = new faceapi.FaceMatcher(labeledDescriptors, 0.7)


    video.addEventListener('play', async () => {
        console.log('Playing')
        const canvas = faceapi.createCanvasFromMedia(video)
        document.body.append(canvas)

        const displaySize = { width: video.width, height: video.height }
        faceapi.matchDimensions(canvas, displaySize)

        

        setInterval(async () => {
            const detections = await faceapi.detectAllFaces(video).withFaceLandmarks().withFaceDescriptors()

            const resizedDetections = faceapi.resizeResults(detections, displaySize)

            canvas.getContext('2d').clearRect(0, 0, canvas.width, canvas.height)

            const results = resizedDetections.map((d) => {
                return faceMatcher.findBestMatch(d.descriptor)
            })
            results.forEach( (result, i) => {
                const box = resizedDetections[i].detection.box
                const drawBox = new faceapi.draw.DrawBox(box, { label: result.toString() })
                drawBox.draw(canvas)
            })
        }, 100)


        
    })
}


function loadLabeledImages() {
   
    const labels = ['{!! Auth::user()->firstName!!} {!! Auth::user()->lastName!!} '] // for WebCam
    return Promise.all(
        labels.map(async (label)=>{
            const descriptions = []
            for(let i=1; i<=2; i++) {
                const img = await faceapi.fetchImage(`../images/users/faceidImages/{!! Auth::user()->username !!}_faceId.jpg`)
                const detections = await faceapi.detectSingleFace(img).withFaceLandmarks().withFaceDescriptor()
                console.log(label + i + JSON.stringify(detections))
                descriptions.push(detections.descriptor)
            }
            document.body.append(label+' Faces Loaded | ')
            return new faceapi.LabeledFaceDescriptors(label, descriptions)
        })
    )
}
function startFace() {
var x = document.getElementById("videoInput");

if (x.style.display === "none") {
x.style.display = "block";

} else {
x.style.display = "none";
}
} 
const btn = document.getElementById("button1");

btn.addEventListener("click", ()=>{
    
    if(btn.innerText === "Start face ID"){
        btn.innerText = "Stop face ID";
    }else{
        btn.innerText= "Start Face ID";
    }

});

</script>
@section('scripts')
<script defer src="{{ asset('js/face-api.min.js') }}"></script>
<script defer src="{{ asset('js/faceScript.js') }}"></script>
@endsection