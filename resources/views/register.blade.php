<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite('resources/css/app.css')
    <link href="https://cdn.jsdelivr.net/npm/flowbite@3.1.2/dist/flowbite.min.css" rel="stylesheet" />
    <title>Document</title>
</head>

<body>

    <body class="bg-gray-100">
        <div class="min-h-screen flex justify-center items-center px-4 py-6 font-sans">
            <div class="w-full justify-center items-center max-w-sm sm:max-w-md bg-white flex flex-col rounded-xl p-8 sm:p-10 shadow-xl border border-gray-200">

                <div class="text-center mb-8">
                    <h1 class="font-extrabold text-2xl sm:text-3xl text-gray-800 mb-2">Buku Induk Siswa</h1>
                </div>

                <div class="flex justify-center mb-8">
                    <img src="{{ asset('images/main_logo.jpg') }}" alt="" class="w-60 sm:w-48 object-contain">
                </div>

                <form action="{{ route('register_post') }}" method="POST" class="space-y-6">
                    @csrf

                    <div class="space-y-2">
                        <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207"></path>
                                </svg>
                            </div>
                            <input
                                type="email"
                                id="email"
                                name="email"
                                placeholder="Masukkan Email"
                                value="{{ old('email') }}"
                                class="w-full h-11 sm:h-12 pl-10 pr-4 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200 text-sm sm:text-base" />
                        </div>
                        @error('email')
                        <p class="text-red-500 text-sm">{{ $message }}</p>
                        @enderror
                    </div>


                    <div class="space-y-2">
                        <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                                </svg>
                            </div>
                            <input
                                type="password"
                                id="password"
                                name="password"
                                placeholder="Masukkan Password"
                                class="w-full h-11 sm:h-12 pl-10 pr-10 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200 text-sm sm:text-base" />
                            <button type="button" id="togglePassword" class="absolute inset-y-0 right-5 flex items-center text-gray-400 focus:outline-none" tabindex="-1">
                                <svg id="eyeOpen" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1.458 12C2.732 7.943 6.523 5 12 5c5.477 0 9.268 2.943 10.542 7-1.274 4.057-5.065 7-10.542 7-5.477 0-9.268-2.943-10.542-7z" />
                                    <circle cx="12" cy="12" r="3" stroke="currentColor" stroke-width="2" fill="none" />
                                </svg>
                                <svg id="eyeClosed" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" style="display:none">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.94 17.94A10.97 10.97 0 0112 19c-5.477 0-9.268-2.943-10.542-7a10.97 10.97 0 012.442-4.362M6.343 6.343A9.956 9.956 0 0112 5c5.477 0 9.268 2.943 10.542 7a10.97 10.97 0 01-4.132 5.225M15 12a3 3 0 11-6 0 3 3 0 016 0zm6 6L6 6" />
                                </svg>
                            </button>
                        </div>
                        @error('password')
                        <p class="text-red-500 text-sm">{{ $message }}</p>
                        @enderror
                    </div>


                    <div>
                        <label for="confirm_password" class="block text-sm font-medium text-gray-700 mb-1">Konfirmasi Password</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                                </svg>
                            </div>
                            <input
                                type="password"
                                id="confirm_password"
                                name="confirm_password"
                                placeholder="Masukkan Password"
                                class="w-full h-11 sm:h-12 pl-10 pr-10 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200 text-sm sm:text-base" />
                            <button type="button" id="togglePasswordConfirm" class="absolute inset-y-0 right-5 flex items-center text-gray-400 focus:outline-none" tabindex="-1">
                                <svg id="eyeOpen2" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1.458 12C2.732 7.943 6.523 5 12 5c5.477 0 9.268 2.943 10.542 7-1.274 4.057-5.065 7-10.542 7-5.477 0-9.268-2.943-10.542-7z" />
                                    <circle cx="12" cy="12" r="3" stroke="currentColor" stroke-width="2" fill="none" />
                                </svg>

                                <svg id="eyeClosed2" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" style="display:none">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.94 17.94A10.97 10.97 0 0112 19c-5.477 0-9.268-2.943-10.542-7a10.97 10.97 0 012.442-4.362M6.343 6.343A9.956 9.956 0 0112 5c5.477 0 9.268 2.943 10.542 7a10.97 10.97 0 01-4.132 5.225M15 12a3 3 0 11-6 0 3 3 0 016 0zm6 6L6 6" />
                                </svg>
                            </button>
                        </div>
                        @error('confirm_password')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>


                    <input type="hidden" name="role" value="user">
                    <input type="hidden" name="status" value="pending">

                    <button
                        type="submit"
                        class="w-full py-3 px-4 bg-gray-600 text-white rounded-lg font-semibold hover:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition duration-300 ease-in-out transform hover:scale-[1.02] active:scale-[0.98] text-base sm:text-lg">
                        <span class="flex items-center justify-center">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"></path>
                            </svg>
                            Register
                        </span>
                    </button>
                </form>

                <div class="mt-6 text-sm text-gray-600">
                    Sudah punya akun?
                    <a href="{{ url('login') }}" class="text-blue-600 hover:underline font-medium">Login di sini</a>
                </div>

                <div class="mt-8 text-center">
                    <p class="text-sm sm:text-base text-gray-500">
                        Wise University
                    </p>
                </div>
            </div>
        </div>

        <script>
            const passwordInput = document.getElementById('password');
            // ID input confirm password di HTML adalah 'confirm_password', jadi harus sama di sini
            const confirmPasswordInput = document.getElementById('confirm_password');
            const togglePassword = document.getElementById('togglePassword');
            const togglePasswordConfirm = document.getElementById('togglePasswordConfirm');
            const eyeOpen = document.getElementById('eyeOpen');
            const eyeClosed = document.getElementById('eyeClosed');
            const eyeOpen2 = document.getElementById('eyeOpen2');
            const eyeClosed2 = document.getElementById('eyeClosed2');

            // Logika untuk Password
            togglePassword.addEventListener('click', function() {
                const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
                passwordInput.setAttribute('type', type);

                if (type === 'text') {
                    eyeOpen.style.display = 'none';
                    eyeClosed.style.display = '';
                } else {
                    eyeOpen.style.display = '';
                    eyeClosed.style.display = 'none';
                }
            });

            // Logika yang diperbaiki untuk Konfirmasi Password
            togglePasswordConfirm.addEventListener('click', function() {
                const type = confirmPasswordInput.getAttribute('type') === 'password' ? 'text' : 'password';
                confirmPasswordInput.setAttribute('type', type);

                if (type === 'text') {
                    eyeOpen2.style.display = 'none';
                    eyeClosed2.style.display = '';
                } else {
                    eyeOpen2.style.display = '';
                    eyeClosed2.style.display = 'none';
                }
            });

            // Bagian komentar yang tidak terpakai sudah saya hapus
        </script>

        <script src="https://cdn.jsdelivr.net/npm/flowbite@3.1.2/dist/flowbite.min.js"></script>
        @include('sweetalert::alert')
    </body>
</body>

</html>