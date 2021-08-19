<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Deployed to Liara</title>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

</head>

<body>
    <h1>
        Hooray!
    </h1>

    <canvas id="drawing_canvas"></canvas>

    <script type="text/javascript" src="{{ asset('js/app.js') }}"></script>
</body>

</html>