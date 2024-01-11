<!-- resources/views/userinterface.blade.php -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>S3 Controller User Interface</title>

    <!-- Add some simple styles for a cleaner look -->
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f4f4;
            margin: 20px;
            text-align: center;
        }

        h1 {
            color: #333;
        }

        form {
            margin-top: 20px;
        }

        button {
            padding: 10px;
            margin: 5px;
            background-color: #4caf50;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        ul {
            list-style-type: none;
            padding: 0;
        }

        li {
            background-color: #fff;
            border: 1px solid #ddd;
            margin: 5px 0;
            padding: 10px;
            border-radius: 5px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .error-message {
            color: #f44336;
            margin-top: 5px;
        }
    </style>
</head>
<body>
    <h1>S3 Controller User Interface</h1>

    @if(session('success'))
        <div style="color: green">{{ session('success') }}</div>
    @endif

    <form action="{{ route('upload.file') }}" method="post" enctype="multipart/form-data">
        @csrf
        <input type="file" name="upload_file" style="margin-right: 10px;">
        <button type="submit">Upload File</button>
        @error('upload_file')
            <div class="error-message">{{ $message }}</div>
        @enderror
    </form>

    <form action="{{ route('show.objects') }}" method="post" style="margin-top: 20px;">
        @csrf
        <button type="submit">Show Objects</button>
    </form>

    @if(isset($files) && count($files) > 0)
        <ul>
            @foreach($files as $file)
                <li>
                    <span>{{ $file['name'] }}</span>
                    <div>
                        <form action="{{ route('download.file') }}" method="post" style="display: inline-block;">
                            @csrf
                            <input type="hidden" name="download_file" value="{{ $file['name'] }}">
                            <button type="submit">Download</button>
                        </form>
                        <form action="{{ route('delete.file') }}" method="post" style="display: inline-block;">
                            @csrf
                            <input type="hidden" name="delete_file" value="{{ $file['name'] }}">
                            <button type="submit" style="background-color: #f44336;">Delete</button>
                        </form>
                    </div>
                </li>
            @endforeach
        </ul>
    @endif
</body>
</html>
