<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Upload ting</title>
</head>

<body>
    <form action="store-image" method="POST" enctype="multipart/form-data">
        @csrf
        <input type="file" name="image">
        <input type="submit" value="Submit">
    </form>
</body>

</html>
