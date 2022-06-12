@extends('layouts.userLayout')
@section('content')
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
<style>
 .w4rAnimated_checkmark svg {
  width: 170px;
  display: block;
  margin: 40px auto 0;
}
.w4rAnimated_checkmark .path {
  stroke-dasharray: 1000;
  stroke-dashoffset: 0;
}
.w4rAnimated_checkmark .path.circle {
  -webkit-animation: dash 0.9s ease-in-out;
  animation: dash 0.9s ease-in-out;
}
.w4rAnimated_checkmark .path.line {
  stroke-dashoffset: 1000;
  -webkit-animation: dash 0.9s 0.35s ease-in-out forwards;
  animation: dash 0.9s 0.35s ease-in-out forwards;
}
.w4rAnimated_checkmark .path.check {
  stroke-dashoffset: -100;
  -webkit-animation: dash-check 0.9s 0.35s ease-in-out forwards;
  animation: dash-check 0.9s 0.35s ease-in-out forwards;
}

@-webkit-keyframes dash {
  0% {
    stroke-dashoffset: 1000;
  }
  100% {
    stroke-dashoffset: 0;
  }
}
@keyframes dash {
  0% {
    stroke-dashoffset: 1000;
  }
  100% {
    stroke-dashoffset: 0;
  }
}
@-webkit-keyframes dash-check {
  0% {
    stroke-dashoffset: -100;
  }
  100% {
    stroke-dashoffset: 900;
  }
}
@keyframes dash-check {
  0% {
    stroke-dashoffset: -100;
  }
  100% {
    stroke-dashoffset: 900;
  }
}





p{
    font-size: 300px;
    text-align: center;
margin: 20px 0 60px;
font-size: 1.25em;
&.success {
color: #73AF55;
}
&.error {
color: #D06079;
}
}

</style>
</head>
<body>
    <div class="w4rAnimated_checkmark" style="margin: 200px">
        <svg version="1.1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 130.2 130.2">
          <circle class="path circle" fill="none" stroke="#73AF55" stroke-width="6" stroke-miterlimit="10" cx="65.1" cy="65.1" r="62.1"/>
          <polyline class="path check" fill="none" stroke="#73AF55" stroke-width="6" stroke-linecap="round" stroke-miterlimit="10" points="100.2,40.2 51.5,88.8 29.8,67.5 "/>
        </svg>
        <p style="font-size: 40px" >Payment Succeeded!</p>
    </div>    
</body>
</html>
@endsection