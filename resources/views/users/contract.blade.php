<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    This is the contact  {{ $userFirstName}} 


    @php
        now();
    @endphp
    Dudes signature
    @isset($signature)

    {{ $userFirstName}} {{ $userLastName}} 
    @endisset
</body>
</html>