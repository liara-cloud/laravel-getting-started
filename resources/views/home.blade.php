<!DOCTYPE html>
<html>
<head>
    <title>Webpage to PDF</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@3.3.2/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100 flex justify-center items-center h-screen">
    <div class="bg-white p-8 rounded shadow w-full max-w-md">
        <h1 class="text-2xl font-bold mb-4">Convert Webpage to PDF</h1>
        <form method="POST" action="{{ route('generate.pdf') }}">
            @csrf
            <input type="url" name="url" placeholder="Enter URL" required
                   class="w-full p-2 border rounded mb-4">
            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">
                Generate PDF
            </button>
        </form>
    </div>
</body>
</html>
