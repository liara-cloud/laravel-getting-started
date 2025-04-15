<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>S3 Storage Management</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h1>S3 Storage Management</h1>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if(session('permanentLink'))
        <div class="alert alert-info">
            Permanent Link: <a href="{{ session('permanentLink') }}" target="_blank">{{ session('permanentLink') }}</a>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <h3>Buckets</h3>
    <ul>
        @foreach($buckets as $name => $bucket)
            <li>{{ $name }}: {{ $bucket }}</li>
        @endforeach
    </ul>

    <h3>Files</h3>
    <form action="{{ route('s3.upload') }}" method="POST" enctype="multipart/form-data" class="mb-3">
        @csrf
        <input type="file" name="file" class="form-control">
        <button type="submit" class="btn btn-primary mt-2">Upload</button>
    </form>

    <table class="table">
        <thead>
            <tr>
                <th>File</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($files as $file)
                <tr>
                    <td>{{ $file }}</td>
                    <td>
                        <a href="{{ route('s3.download', $file) }}" class="btn btn-sm btn-info">Download</a>
                        <a href="#" onclick="getPresignedUrl('{{ route('s3.presigned', $file) }}')" class="btn btn-sm btn-secondary">Get Pre-Signed URL</a>
                        <a href="{{ Storage::disk('s3')->url($file) }}" target="_blank" class="btn btn-sm btn-success">Get Permanent Link</a>
                        <form action="{{ route('s3.delete', $file) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

<script>
    function getPresignedUrl(url) {
        fetch(url)
            .then(response => response.json())
            .then(data => {
                alert('Pre-Signed URL: ' + data.url);
            })
            .catch(error => console.error('Error:', error));
    }
</script>
</body>
</html>