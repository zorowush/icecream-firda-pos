<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>

    <meta charset="utf-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1">

    <meta name="csrf-token"
          content="{{ csrf_token() }}">

    <title>Ice Cream Firda POS</title>

    <link rel="preconnect"
          href="https://fonts.bunny.net">

    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap"
          rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])

</head>

<body class="font-sans antialiased">

<div class="min-h-screen d-flex justify-center items-center bg-gradient-to-br from-blue-100 to-blue-200">

    <div class="w-full max-w-md">

        <div class="text-center mb-6">

            <div class="text-6xl mb-3">
                🍦
            </div>

            <h1 class="text-3xl font-bold text-sky-700">
                Ice Cream Firda
            </h1>

            <p class="text-gray-600">
                Silakan login untuk melanjutkan
            </p>

        </div>

        <div class="bg-white shadow-xl rounded-xl px-8 py-6">

            {{ $slot }}

        </div>

        <div class="text-center text-gray-500 text-sm mt-5">

            © 2026 Ice Cream Firda POS

        </div>

    </div>

</div>

</body>

</html>