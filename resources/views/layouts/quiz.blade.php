<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <link rel="icon" type="image/x-icon" href="https://kzl.nis.edu.kz/wp-content/uploads/2017/02/logo_black.png">
        <meta http-equiv="pragma" content="no-cache">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>
        
        @routes
        
        <script
            src=https://code.jquery.com/jquery-3.7.0.min.js
            integrity="sha256-2Pmvv0kuTBOenSvLm6bvfBSSHrUJ+3A7x6P5Ebd07/g="
            crossorigin="anonymous"></script>

        <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
        <!-- CDN -->

        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;700&family=Roboto:wght@700&display=swap" rel="stylesheet">

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
        <link href="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.6.5/flowbite.min.css" rel="stylesheet" />
        <!-- Scripts -->
        @vite(['resources/css/style.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased min-h-screen">
        <div class="min-h-screen bg-gray-100 dark:bg-gray-900">
            @include('layouts.navigation')

            <!-- Page Heading -->
            @if (isset($header))
                <header class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 border-gray-200">
                    <div class="h-12 flex items-center max-w-7xl mx-auto py-4 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endif

            <!-- Page Content -->
            <main class="min-h-screen">
                {{ $slot }}
            </main>
        </div>
        <script src="https://kit.fontawesome.com/6aa8c7745b.js" crossorigin="anonymous"></script>
    </body>
</html>
