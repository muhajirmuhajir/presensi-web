<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Sistem Informasi Presensi</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">

    <!-- Styles -->
    <link rel="stylesheet" href="{{asset('css/app.css')}}">

    <style>
        body {
            font-family: 'Nunito', sans-serif;
        }
    </style>
</head>

<body class="antialiased">
    <div
        class="relative flex items-top justify-center min-h-screen bg-gray-100 dark:bg-gray-900 sm:items-center py-4 sm:pt-0">


        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
            <div class="flex justify-center pt-8 sm:justify-center sm:pt-0">
                <img src="{{ asset('success-icon.png')}}" alt="" srcset="" class="h-14">
            </div>
            <h1 class="text-2xl text-center">Berhasil</h1>
            <p class="text-sm text-gray-700">Akun Aktifasi Berhasil, Silahkan Login</p>
            <div class="flex justify-center my-4">
                <x-button-link href="{{route('login')}}">Login</x-button-link>
            </div>
        </div>
    </div>
    </div>
</body>

</html>
