<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Toko Online')</title>

    </head>
<body class="bg-gray-100 font-sans antialiased">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    {{-- Desktop Nav --}}
    <nav class="bg-white shadow-md hidden sm:block">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                {{-- Logo --}}
                <a href="/" class="text-2xl font-bold text-gray-800">
                    eTicketing
                </a>

                {{-- Desktop Nav Links --}}
                <div class="flex items-center space-x-8">
                    <a href="/" class="text-gray-500 hover:text-gray-700">Events</a>
                    <a href="#" class="text-gray-500 hover:text-gray-700">My Tickets</a>
                    <a href="/admin" class="text-gray-500 hover:text-gray-700">Admin</a>
                </div>
            </div>
        </div>
    </nav>

    {{-- Main Content --}}
    <main class="container mx-auto px-4 sm:px-6 lg:px-8 py-8 mb-16 sm:mb-0">
        @yield('content')
    </main>

    {{-- Mobile Bottom Navigation --}}
    <div class="fixed bottom-0 left-0 right-0 bg-white border-t border-gray-200 z-50 sm:hidden shadow-lg">
        <div class="flex h-16 justify-around items-center text-gray-500">
            <a href="/" class="flex flex-col items-center justify-center p-2 text-center text-blue-500">
                <svg class="w-6 h-6 mb-1" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                    <path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"></path>
                </svg>
                <span class="text-xs">Home</span>
            </a>
            <a href="#" class="flex flex-col items-center justify-center p-2 text-center hover:text-blue-500">
                <svg class="w-6 h-6 mb-1" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd" d="M3 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z" clip-rule="evenodd"></path>
                </svg>
                <span class="text-xs">Events</span>
            </a>
            <a href="#" class="flex flex-col items-center justify-center p-2 text-center hover:text-blue-500">
                <svg class="w-6 h-6 mb-1" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-6-3a2 2 0 11-4 0 2 2 0 014 0zm-2 4a5 5 0 00-4.546 2.916A5.98 5.98 0 0110 16a5.979 5.979 0 01-4.454-2.084A5 5 0 0010 11z" clip-rule="evenodd"></path>
                </svg>
                <span class="text-xs">Profile</span>
            </a>
        </div>
    </div>

</body>
</html>
