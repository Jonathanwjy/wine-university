<footer class="bg-gray-800 text-white mt-10">
    <div class="max-w-7xl mx-auto py-12 px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-2 md:grid-cols-4 gap-8">

            <div class="col-span-2 md:col-span-1 space-y-4">
                <a href="{{ url('/') }}">
                    <img class="h-10 w-auto" src="{{ asset('images/main_logo.jpg') }}" alt="Logo Footer">
                </a>
                <p class="text-sm text-gray-400">
                    WISE University adalah institusi pendidikan tinggi yang berkomitmen pada Knowledge, Innovation, dan Freedom.
                </p>
                <div class="flex space-x-4">
                    <a href="#" class="text-gray-400 hover:text-white transition duration-150"><i class="fab fa-facebook-f"></i></a>
                    <a href="#" class="text-gray-400 hover:text-white transition duration-150"><i class="fab fa-twitter"></i></a>
                    <a href="#" class="text-gray-400 hover:text-white transition duration-150"><i class="fab fa-instagram"></i></a>
                </div>
            </div>

            <div>
                <h3 class="text-base font-semibold text-white tracking-wider uppercase mb-4">Akses Cepat</h3>
                <ul class="space-y-3">
                    <li>
                        <a href="{{ url('/home') }}" class="text-sm text-gray-400 hover:text-white transition duration-150">Home</a>
                    </li>
                    <li>
                        <a href="{{ url('/about') }}" class="text-sm text-gray-400 hover:text-white transition duration-150">About</a>
                    </li>
                    <li>
                        <a href="{{ url('/program-studi') }}" class="text-sm text-gray-400 hover:text-white transition duration-150">Program Studi</a>
                    </li>
                    <li>
                        <a href="{{ url('/berita') }}" class="text-sm text-gray-400 hover:text-white transition duration-150">Berita & Acara</a>
                    </li>
                </ul>
            </div>

            <div>
                <h3 class="text-base font-semibold text-white tracking-wider uppercase mb-4">Hubungi Kami</h3>
                <address class="space-y-3 text-sm text-gray-400 not-italic">
                    <p>Jl. Pendidikan No. 123, Kota Teknologi</p>
                    <p>
                        Email: <a href="mailto:info@wise.ac.id" class="hover:text-white">info@wise.ac.id</a>
                    </p>
                    <p>
                        Telepon: <a href="tel:+6221123456" class="hover:text-white">(+62) 21 1234 5678</a>
                    </p>
                </address>
            </div>

            <div>
                <h3 class="text-base font-semibold text-white tracking-wider uppercase mb-4">Visi & Misi</h3>
                <ul class="space-y-3">
                    <li>
                        <a href="{{ url('/visi-misi') }}" class="text-sm text-gray-400 hover:text-white transition duration-150">Visi Misi Kami</a>
                    </li>
                    <li>
                        <a href="{{ url('/faq') }}" class="text-sm text-gray-400 hover:text-white transition duration-150">FAQ</a>
                    </li>
                    <li>
                        <a href="{{ url('/karir') }}" class="text-sm text-gray-400 hover:text-white transition duration-150">Karir</a>
                    </li>
                </ul>
            </div>

        </div>

        <div class="mt-8 border-t border-gray-700 pt-8">
            <p class="text-center text-sm text-gray-400">
                &copy; {{ date('Y') }} WISE University. All rights reserved.
            </p>
        </div>
    </div>
</footer>