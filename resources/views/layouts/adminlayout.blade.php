<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Sweat Alert-->

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>

     <!-- icon-->

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

       <!-- bootstrap-->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.0.1/css/bootstrap.min.css" rel="stylesheet">
    

    <!-- Fonts and Styles -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('assets/css/tailwind.output.css') }}">
    @vite('resources/css/app.css')
  

    <!-- Alpine.js -->
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@2.x.x/dist/alpine.min.js" defer></script>
</head>
<body>
    <div x-data="{ isSideMenuOpen: false, isProfileMenuOpen: false, isNotificationsMenuOpen: false }" class="flex h-screen bg-gray-50 dark:bg-gray-900">
        <!-- Desktop sidebar -->
        @include('layouts.admin.sidebar')

        <div class="flex flex-col flex-1 w-full">

            @include('layouts.admin.header')
 
            <!-- Main content -->
            <main class="h-full overflow-y-auto">
                <div class="container px-6 mx-auto grid">
                  @yield('content')
                </div>
            </main>
        </div>
    </div>


    <script src="{{ asset('assets/js/jquery-3.7.1.min.js') }}"></script>
</body>
</html>
