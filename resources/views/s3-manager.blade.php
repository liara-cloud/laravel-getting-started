<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>S3 File Manager - {{ config('app.name', 'Laravel') }}</title>
    
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />
    
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Instrument Sans', ui-sans-serif, system-ui, sans-serif;
            background: #ffffff;
            min-height: 100vh;
            padding: 2rem;
            color: #000000;
        }
        
        .container {
            max-width: 1200px;
            margin: 0 auto;
        }
        
        .header {
            border-bottom: 1px solid #e5e5e5;
            padding: 2rem 0;
            margin-bottom: 2rem;
        }
        
        .header h1 {
            font-size: 2rem;
            color: #000000;
            margin-bottom: 0.5rem;
            font-weight: 400;
            letter-spacing: -0.02em;
        }
        
        .bucket-info {
            color: #666666;
            font-size: 0.875rem;
            font-weight: 400;
        }
        
        .upload-section {
            border: 1px solid #e5e5e5;
            padding: 2rem;
            margin-bottom: 2rem;
        }
        
        .upload-area {
            border: 1px dashed #cccccc;
            padding: 3rem;
            text-align: center;
            transition: border-color 0.2s;
            cursor: pointer;
        }
        
        .upload-area:hover {
            border-color: #000000;
        }
        
        .upload-area.dragover {
            border-color: #000000;
            background: #fafafa;
        }
        
        .upload-icon {
            font-size: 2rem;
            margin-bottom: 1rem;
            color: #666666;
        }
        
        .upload-text {
            color: #666666;
            margin-bottom: 1rem;
            font-size: 0.875rem;
        }
        
        .btn {
            background: #000000;
            color: #ffffff;
            border: 1px solid #000000;
            padding: 0.75rem 2rem;
            font-size: 0.875rem;
            font-weight: 400;
            cursor: pointer;
            transition: all 0.2s;
            letter-spacing: 0.02em;
        }
        
        .btn:hover {
            background: #ffffff;
            color: #000000;
        }
        
        .btn:disabled {
            opacity: 0.3;
            cursor: not-allowed;
        }
        
        .files-section {
            border: 1px solid #e5e5e5;
            padding: 2rem;
        }
        
        .files-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 2rem;
            padding-bottom: 1rem;
            border-bottom: 1px solid #e5e5e5;
        }
        
        .files-header h2 {
            font-size: 1.25rem;
            color: #000000;
            font-weight: 400;
            letter-spacing: -0.01em;
        }
        
        .file-count {
            border: 1px solid #e5e5e5;
            padding: 0.5rem 1rem;
            color: #666666;
            font-weight: 400;
            font-size: 0.875rem;
        }
        
        .files-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
            gap: 1px;
            background: #e5e5e5;
            border: 1px solid #e5e5e5;
        }
        
        .file-card {
            background: #ffffff;
            padding: 1.5rem;
            transition: background 0.2s;
        }
        
        .file-card:hover {
            background: #fafafa;
        }
        
        .file-icon {
            font-size: 2rem;
            margin-bottom: 1rem;
            text-align: center;
            color: #666666;
        }
        
        .file-name {
            font-weight: 400;
            color: #000000;
            margin-bottom: 0.75rem;
            word-break: break-word;
            font-size: 0.875rem;
        }
        
        .file-meta {
            font-size: 0.75rem;
            color: #999999;
            margin-bottom: 0.25rem;
            font-weight: 400;
        }
        
        .file-actions {
            display: flex;
            flex-direction: column;
            gap: 1px;
            margin-top: 1rem;
        }
        
        .action-row {
            display: flex;
            gap: 1px;
        }
        
        .btn-small {
            flex: 1;
            padding: 0.625rem;
            font-size: 0.75rem;
            background: #ffffff;
            color: #000000;
            border: 1px solid #e5e5e5;
            cursor: pointer;
            transition: all 0.2s;
            font-weight: 400;
            letter-spacing: 0.02em;
        }
        
        .btn-small:hover {
            background: #000000;
            color: #ffffff;
            border-color: #000000;
        }
        
        .url-modal {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.5);
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 1000;
        }
        
        .url-modal-content {
            background: #ffffff;
            border: 1px solid #000000;
            padding: 2rem;
            max-width: 600px;
            width: 90%;
        }
        
        .url-modal-header {
            font-size: 1.125rem;
            margin-bottom: 1rem;
            font-weight: 400;
        }
        
        .url-display {
            background: #fafafa;
            border: 1px solid #e5e5e5;
            padding: 1rem;
            margin-bottom: 1rem;
            word-break: break-all;
            font-size: 0.875rem;
            font-family: monospace;
        }
        
        .url-actions {
            display: flex;
            gap: 1px;
        }
        
        .alert {
            padding: 1rem;
            margin-bottom: 1rem;
            border: 1px solid #e5e5e5;
            font-size: 0.875rem;
        }
        
        .alert-error {
            background: #ffffff;
            color: #000000;
        }
        
        .alert-success {
            background: #ffffff;
            color: #000000;
        }
        
        .empty-state {
            text-align: center;
            padding: 4rem 2rem;
            color: #999999;
        }
        
        .empty-icon {
            font-size: 3rem;
            margin-bottom: 1rem;
            opacity: 0.3;
        }
        
        .empty-state p {
            font-size: 0.875rem;
        }
        
        .loading {
            display: inline-block;
            width: 16px;
            height: 16px;
            border: 2px solid #e5e5e5;
            border-radius: 50%;
            border-top-color: #000000;
            animation: spin 1s linear infinite;
        }
        
        @keyframes spin {
            to { transform: rotate(360deg); }
        }
        
        .hidden {
            display: none;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>S3 File Manager</h1>
            <div class="bucket-info">
                Bucket: {{ $bucket ?? 'Not configured' }}
            </div>
        </div>

        @if(isset($error))
        <div class="alert alert-error">
            Error: {{ $error }}
        </div>
        @endif

        <div id="alertContainer"></div>

        <div class="upload-section">
            <form id="uploadForm" enctype="multipart/form-data">
                @csrf
                <div class="upload-area" id="uploadArea">
                    <div class="upload-icon">↑</div>
                    <div class="upload-text">
                        Click to upload or drag and drop
                    </div>
                    <input type="file" id="fileInput" name="file" style="display: none;">
                    <button type="button" class="btn" onclick="document.getElementById('fileInput').click()">
                        CHOOSE FILE
                    </button>
                </div>
            </form>
        </div>

        <div class="files-section">
            <div class="files-header">
                <h2>Files</h2>
                <div class="file-count">{{ $files->count() }} {{ $files->count() === 1 ? 'file' : 'files' }}</div>
            </div>

            @if($files->isEmpty())
            <div class="empty-state">
                <div class="empty-icon">—</div>
                <p>No files in your bucket yet</p>
            </div>
            @else
            <div class="files-grid" id="filesGrid">
                @foreach($files as $file)
                <div class="file-card" data-filename="{{ $file['path'] }}">
                    <div class="file-icon">□</div>
                    <div class="file-name">{{ $file['name'] }}</div>
                    <div class="file-meta">{{ number_format($file['size'] / 1024, 2) }} KB</div>
                    <div class="file-meta">{{ date('Y-m-d H:i', $file['lastModified']) }}</div>
                    <div class="file-actions">
                        <div class="action-row">
                            <button class="btn-small" onclick="downloadFile('{{ $file['path'] }}')">
                                DOWNLOAD
                            </button>
                            <button class="btn-small" onclick="deleteFile('{{ $file['path'] }}')">
                                DELETE
                            </button>
                        </div>
                        <div class="action-row">
                            <button class="btn-small" onclick="getTempUrl('{{ $file['path'] }}')">
                                TEMP LINK (1H)
                            </button>
                            <button class="btn-small" onclick="getPermanentUrl('{{ $file['path'] }}')">
                                PERMANENT LINK
                            </button>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            @endif
        </div>
    </div>

    <!-- URL Modal -->
    <div id="urlModal" class="url-modal hidden">
        <div class="url-modal-content">
            <div class="url-modal-header" id="urlModalTitle">File URL</div>
            <div class="url-display" id="urlDisplay"></div>
            <div class="url-actions">
                <button class="btn-small" onclick="copyUrl()">COPY URL</button>
                <button class="btn-small" onclick="closeUrlModal()">CLOSE</button>
            </div>
        </div>
    </div>

    <script>
        // CSRF token setup
        const csrfToken = document.querySelector('meta[name="csrf-token"]').content;

        // Alert functions
        function showAlert(message, type = 'success') {
            const alertContainer = document.getElementById('alertContainer');
            const alert = document.createElement('div');
            alert.className = `alert alert-${type}`;
            alert.textContent = message;
            alertContainer.appendChild(alert);
            
            setTimeout(() => {
                alert.remove();
            }, 5000);
        }

        // File upload handling
        const fileInput = document.getElementById('fileInput');
        const uploadArea = document.getElementById('uploadArea');
        const uploadForm = document.getElementById('uploadForm');

        fileInput.addEventListener('change', function(e) {
            if (this.files.length > 0) {
                uploadFile(this.files[0]);
            }
        });

        // Drag and drop
        uploadArea.addEventListener('dragover', function(e) {
            e.preventDefault();
            this.classList.add('dragover');
        });

        uploadArea.addEventListener('dragleave', function(e) {
            e.preventDefault();
            this.classList.remove('dragover');
        });

        uploadArea.addEventListener('drop', function(e) {
            e.preventDefault();
            this.classList.remove('dragover');
            
            if (e.dataTransfer.files.length > 0) {
                uploadFile(e.dataTransfer.files[0]);
            }
        });

        // Upload file function
        async function uploadFile(file) {
            const formData = new FormData();
            formData.append('file', file);

            try {
                const response = await fetch('{{ route("s3.upload") }}', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': csrfToken
                    },
                    body: formData
                });

                const data = await response.json();

                if (data.success) {
                    showAlert('File uploaded successfully!', 'success');
                    setTimeout(() => location.reload(), 1500);
                } else {
                    showAlert(data.message, 'error');
                }
            } catch (error) {
                showAlert('Upload failed: ' + error.message, 'error');
            }
        }

        // Download file function
        function downloadFile(filename) {
            window.location.href = `/download/${encodeURIComponent(filename)}`;
        }

        // Delete file function
        async function deleteFile(filename) {
            if (!confirm('Are you sure you want to delete this file?')) {
                return;
            }

            try {
                const response = await fetch(`/delete/${encodeURIComponent(filename)}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': csrfToken,
                        'Content-Type': 'application/json'
                    }
                });

                const data = await response.json();

                if (data.success) {
                    showAlert('File deleted successfully!', 'success');
                    
                    // Remove the file card from the DOM
                    const fileCard = document.querySelector(`[data-filename="${filename}"]`);
                    if (fileCard) {
                        fileCard.remove();
                    }
                    
                    // Update file count
                    setTimeout(() => location.reload(), 1500);
                } else {
                    showAlert(data.message, 'error');
                }
            } catch (error) {
                showAlert('Delete failed: ' + error.message, 'error');
            }
        }

        // Get temporary URL (1 hour)
        async function getTempUrl(filename) {
            try {
                const response = await fetch(`/temp-url/${encodeURIComponent(filename)}`);
                const data = await response.json();

                if (data.success) {
                    showUrlModal('Temporary URL (expires in 1 hour)', data.url);
                } else {
                    showAlert(data.message, 'error');
                }
            } catch (error) {
                showAlert('Failed to generate temporary URL: ' + error.message, 'error');
            }
        }

        // Get permanent URL
        async function getPermanentUrl(filename) {
            try {
                const response = await fetch(`/permanent-url/${encodeURIComponent(filename)}`);
                const data = await response.json();

                if (data.success) {
                    showUrlModal('Permanent URL', data.url);
                } else {
                    showAlert(data.message, 'error');
                }
            } catch (error) {
                showAlert('Failed to generate permanent URL: ' + error.message, 'error');
            }
        }

        // Show URL modal
        function showUrlModal(title, url) {
            document.getElementById('urlModalTitle').textContent = title;
            document.getElementById('urlDisplay').textContent = url;
            document.getElementById('urlModal').classList.remove('hidden');
            window.currentUrl = url;
        }

        // Close URL modal
        function closeUrlModal() {
            document.getElementById('urlModal').classList.add('hidden');
        }

        // Copy URL to clipboard
        function copyUrl() {
            const url = window.currentUrl;
            navigator.clipboard.writeText(url).then(() => {
                showAlert('URL copied to clipboard!', 'success');
                closeUrlModal();
            }).catch(err => {
                showAlert('Failed to copy URL', 'error');
            });
        }

        // Close modal on background click
        document.getElementById('urlModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeUrlModal();
            }
        });
    </script>
</body>
</html>