<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Add agency</title>
</head>
<body>
    <form action="{{ route('owner.createAgencyPost') }}" method="POST">
        @csrf
        <input type="text" name="name" id="" placeholder="Name">
        <input type="text" name="registeryNb" id="" placeholder="Registre nb">
        <input type="submit" value="Submit" >
    </form>
</body>
</html>