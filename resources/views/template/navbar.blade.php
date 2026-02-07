<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    @vite('resources/css/app.css')
    <link href="https://cdn.jsdelivr.net/npm/flowbite@3.1.2/dist/flowbite.min.css" rel="stylesheet" />

</head>

<body class="scroll-smooth">
    <nav class="bg-white h-24 shadow-md sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-full">
            <div class="flex justify-between h-full items-center">
                <div class="flex items-center">
                    <a href="{{ url('/') }}" class="flex items-center">
                        <img class="h-20 w-auto" src="{{ asset('images/main_logo.jpg') }}" alt="Logo">
                    </a>

                    <div class="hidden sm:ml-6 sm:flex sm:space-x-8 h-full">
                        <a href="{{ url('/') }}" class="text-gray-900 inline-flex items-center px-1 pt-1 text-xl font-medium border-b-2 border-transparent hover:border-blue-500 transition duration-150 ease-in-out">Home</a>
                        <a href="{{ url('/') }}#about" class="text-gray-500 inline-flex items-center px-1 pt-1 text-xl font-medium border-b-2 border-transparent hover:border-blue-500 transition duration-150 ease-in-out">About</a>
                        <a href="{{ url('/') }}#prodi" class="text-gray-500 inline-flex items-center px-1 pt-1 text-xl font-medium border-b-2 border-transparent hover:border-blue-500 transition duration-150 ease-in-out">Program Studi</a>
                        <a href="{{ url('/') }}#visi-misi" class="text-gray-500 inline-flex items-center px-1 pt-1 text-xl font-medium border-b-2 border-transparent hover:border-blue-500 transition duration-150 ease-in-out">Visi Misi</a>
                    </div>
                </div>

                <div class="flex items-center space-x-4">

                    @auth
                    <div class="relative">
                        <button id="user-menu-button" type="button" class="max-w-xs bg-gray-800 rounded-full flex items-center text-sm focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-gray-800 focus:ring-white" aria-expanded="false" aria-haspopup="true">
                            <span class="sr-only">Open user menu</span>
                            <img class="h-10 w-10 rounded-full" src="https://ui-avatars.com/api/?name={{ Auth::user()->email }}&background=0D83BF&color=fff" alt="User Profile">
                        </button>

                        <div id="user-menu-dropdown" class="origin-top-right absolute right-0 mt-2 w-48 rounded-md shadow-lg py-1 bg-white ring-1 ring-black ring-opacity-5 focus:outline-none hidden" role="menu" aria-orientation="vertical" aria-labelledby="user-menu-button" tabindex="-1">
                            @if(auth()->user()->role == 'admin')
                            <a href="{{ url('/admin/dashboard') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Dashboard</a>
                            @elseif(auth()->user()->role == 'user')
                            <a href="{{ url('status-pendaftaran') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Cek Pendaftaran</a>
                            @endif
                            <a href="{{ url('logout') }}">
                                @csrf
                                <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                    Logout
                                </button>
                            </a>
                        </div>
                    </div>
                    @endauth

                    @guest
                    <div class="relative">
                        <button id="guest-menu-button" type="button" class="max-w-xs bg-gray-200 rounded-full flex items-center text-sm p-3 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-gray-800 focus:ring-indigo-500 transition duration-150 ease-in-out" aria-expanded="false" aria-haspopup="true">
                            <span class="sr-only">Open auth menu</span>
                            <svg class="h-6 w-6 text-gray-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1" />
                            </svg>
                        </button>

                        <div id="guest-menu-dropdown" class="origin-top-right absolute right-0 mt-2 w-48 rounded-md shadow-lg py-1 bg-white ring-1 ring-black ring-opacity-5 focus:outline-none hidden" role="menu" aria-orientation="vertical" aria-labelledby="guest-menu-button" tabindex="-1">
                            <a href="{{ route('login') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100" role="menuitem" tabindex="-1">
                                Login
                            </a>
                            <a href="{{ route('register') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100" role="menuitem" tabindex="-1">
                                Register
                            </a>
                        </div>
                    </div>
                    @endguest

                </div>
            </div>
        </div>
    </nav>

    <div>
        @yield('content')
    </div>

    @extends('template.footer')

    <script>
        const userButton = document.getElementById('user-menu-button');
        const userDropdown = document.getElementById('user-menu-dropdown');

        if (userButton && userDropdown) {
            userButton.addEventListener('click', () => {
                userDropdown.classList.toggle('hidden');
            });

            document.addEventListener('click', (event) => {
                if (!userButton.contains(event.target) && !userDropdown.contains(event.target)) {
                    userDropdown.classList.add('hidden');
                }
            });
        }

        const guestButton = document.getElementById('guest-menu-button');
        const guestDropdown = document.getElementById('guest-menu-dropdown');

        if (guestButton && guestDropdown) {
            guestButton.addEventListener('click', () => {
                guestDropdown.classList.toggle('hidden');
            });

            document.addEventListener('click', (event) => {
                if (!guestButton.contains(event.target) && !guestDropdown.contains(event.target)) {
                    guestDropdown.classList.add('hidden');
                }
            });
        }
    </script>

    <script src="https://cdn.jsdelivr.net/npm/flowbite@3.1.2/dist/flowbite.min.js"></script>
    @include('sweetalert::alert')
</body>

</html>