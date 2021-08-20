<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>استقرار برنامه‌ی آپلود فایل در لیارا</title>
    <link href="{{ asset('img/icon.svg') }}" rel="shortcut icon" type="image/x-icon">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
    <link href="{{ asset('css/upload.css') }}" rel="stylesheet">
</head>

<body>
    <div class="container mt-5">
        <form action="{{ route('uploadFile') }}" method="post" enctype="multipart/form-data">
            <h3 class="text-center mb-5">File Upload in Laravel</h3>
            @csrf
            @if ($message = Session::get('success'))
                <div class="alert alert-success">
                    <strong>{{ $message }}</strong>
                </div>
            @endif

            @if (count($errors) > 0)
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="custom-file">
                <input type="file" name="file" class="custom-file-input" id="chooseFile">
                <label class="custom-file-label" for="chooseFile">Select file</label>
            </div>

            <button type="submit" name="submit" class="btn btn-primary btn-block mt-4">
                Upload Files
            </button>
        </form>
        <div class="container-fluid bg-light" style="margin: 15px 0 0 0">
            @foreach ($files as $file)
                <p>{{ $file }} <a href="{{ 'files/' . $file }}" target="_blank">Download</a></p>
            @endforeach
        </div>
    </div>

    <script>
        const input = document.getElementById('chooseFile');
        input.addEventListener('change', changeFileName);

        function changeFileName(event) {
            const label = document.getElementsByClassName('custom-file-label');
            label[0].innerHTML = event.srcElement.files[0].name;
        }
    </script>
</body>

</html>
