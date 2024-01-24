<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Image Upload</title>

    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .container {
            max-width: 400px;
            width: 100%;
            padding: 20px;
            box-sizing: border-box;
            background-color: #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            text-align: center;
            margin-top: 20px;
        }

        h2 {
            color: #333;
            margin-bottom: 20px;
        }

        p {
            color: #777;
            margin-bottom: 20px;
        }

        form {
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .custom-file {
            position: relative;
            overflow: hidden;
            margin: 10px 0;
        }

        .custom-file-input {
            position: absolute;
            font-size: 100px;
            right: 0;
            top: 0;
            opacity: 0;
        }

        .custom-file-label {
            display: block;
            overflow: hidden;
            white-space: nowrap;
            text-overflow: ellipsis;
            background-color: #4caf50;
            color: #fff;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .custom-file-label:hover {
            background-color: #45a049;
        }

        .progress-container {
            width: 100%;
            height: 30px;
            background-color: #ddd;
            border-radius: 5px;
            margin: 10px 0;
            overflow: hidden;
        }

        .progress-bar {
            height: 100%;
            width: 0;
            background-color: #4caf50;
            text-align: center;
            line-height: 30px;
            color: #fff;
        }

        button {
            background-color: #4caf50;
            color: #fff;
            border: none;
            padding: 10px 20px;
            cursor: pointer;
            font-size: 16px;
            margin-top: 10px;
            transition: background-color 0.3s ease;
        }

        button:hover {
            background-color: #45a049;
        }

        a {
            color: #3498db;
            text-decoration: none;
            display: block;
            margin-top: 10px;
        }
    </style>
</head>
<body>

    <div class="container">

        @if(session('success'))
            <h2>Upload Successful! 🤩</h2>
            <p>{{ session('success') }}</p>
            <a href="/uploads/{{ session('image') }}" target="_blank">View Image</a>
            <button onclick="reloadPage()">Upload Again</button>
        @else
            <h2>Image Upload</h2>
            <form action="{{ route('image.upload') }}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="custom-file">
                    <input type="file" id="image" name="image" accept="image/*" class="custom-file-input" onchange="displayFileName()">
                    <label class="custom-file-label" for="image">Choose File To Upload Please</label>
                </div>
                <div class="progress-container">
                    <div class="progress-bar" id="progress-bar">0%</div>
                </div>
                <button type="submit" id="upload-btn" onclick="uploadFile()">Upload</button>
            </form>
        @endif

    </div>

    <script>
        function uploadFile() {
            var progressBar = document.getElementById('progress-bar');
            var uploadBtn = document.getElementById('upload-btn');

            var fileInput = document.getElementById('image');
            var file = fileInput.files[0];

            if (file) {
                var formData = new FormData();
                formData.append('image', file);

                var xhr = new XMLHttpRequest();
                xhr.open('post', '{{ route("image.upload") }}', true);

                xhr.upload.onprogress = function (e) {
                    if (e.lengthComputable) {
                        var percentage = (e.loaded / e.total) * 100;
                        progressBar.style.width = percentage + '%';
                        progressBar.innerHTML = Math.round(percentage) + '%';
                        uploadBtn.disabled = true;
                    }
                };

                xhr.onload = function () {
                    if (xhr.status === 200) {
                        var response = JSON.parse(xhr.responseText);
                        progressBar.style.width = '100%';
                        progressBar.innerHTML = '100%';
                        uploadBtn.disabled = false;

                        // Optional: You can handle the response here
                        console.log(response);
                    }
                };

                xhr.send(formData);
            }
        }

        function reloadPage() {
            location.reload();
        }

        function displayFileName() {
            var fileLabel = document.querySelector('.custom-file-label');
            var fileInput = document.getElementById('image');
            fileLabel.innerText = fileInput.files[0].name;
        }
    </script>

</body>
</html>
