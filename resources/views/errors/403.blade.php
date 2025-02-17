<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>403 - Akses Ditolak</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100 flex items-center justify-center h-screen">
    <div class="bg-white p-8 rounded-lg shadow-lg text-center">
        <h1 class="text-4xl font-bold text-red-600 mb-4">Akses Ditolak</h1>
        <p class="text-gray-700 mb-6">Anda tidak memiliki izin untuk mengakses halaman ini.</p>
        <a href="{{ route('home') }}" class="bg-blue-500 text-white px-6 py-2 rounded-lg hover:bg-blue-600 transition duration-300">
            Kembali ke Dashboard User
        </a>
    </div>
</body>
</html>