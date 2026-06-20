<footer class="bg-biruputih pt-16 pb-8 px-6 lg:px-24 w-full">
    <div class=" mx-auto flex flex-col gap-12">
        
        {{-- Top Section: 4 Columns --}}
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8 lg:gap-12">
            
            {{-- Column 1: Logo & Address --}}
            <div class="flex flex-col gap-4">
                <img src="{{ asset('img/logo.png') }}" alt="Basecamp Outdoor" class="h-12 w-auto object-contain object-left mb-2">
                <p class="text-sm text-gray-600 leading-relaxed max-w-[260px]">
                    Jaranan Jl. Pedak, Jaranan,<br>
                    Banguntapan, Kec. Banguntapan,<br>
                    Kabupaten Bantul, Daerah<br>
                    Istimewa Yogyakarta 55198
                </p>
                <div class="flex gap-3 mt-2">
                    <a href="#" class="w-9 h-9 rounded-full  flex items-center justify-center text-gray-700 hover:bg-blue-400 transition-colors">
                        <img src="{{ asset('icon/sosmed.svg') }}" alt="Sosmed" class="w-8 h-8">
                    </a>
                    <a href="#" class="w-9 h-9 rounded-full  flex items-center justify-center text-gray-700 hover:bg-blue-400 transition-colors">
                        <img src="{{ asset('icon/lokasi.svg') }}" alt="Lokasi" class="w-8 h-8">
                    </a>
                </div>
            </div>

            {{-- Column 2: Navigasi --}}
            <div class="flex flex-col gap-4 lg:pl-4">
                <h3 class="font-bold text-sm tracking-wider text-primary mb-2 uppercase">Navigasi</h3>
                <ul class="flex flex-col gap-4 text-sm text-gray-600">
                    <li><a href="#" class="hover:text-primary transition-colors">Home</a></li>
                    <li><a href="#" class="hover:text-primary transition-colors">Rental Alat</a></li>
                    <li><a href="#" class="hover:text-primary transition-colors">Service</a></li>
                    <li><a href="#" class="hover:text-primary transition-colors">Contact Us</a></li>
                </ul>
            </div>

            {{-- Column 3: Informasi --}}
            <div class="flex flex-col gap-4">
                <h3 class="font-bold text-sm tracking-wider text-primary mb-2 uppercase">Informasi</h3>
                <ul class="flex flex-col gap-4 text-sm text-gray-600">
                    <li><a href="#" class="hover:text-primary transition-colors">Privacy Policy</a></li>
                    <li><a href="#" class="hover:text-primary transition-colors">Terms of Service</a></li>
                    <li><a href="#" class="hover:text-primary transition-colors">Shipping Info</a></li>
                    <li><a href="#" class="hover:text-primary transition-colors">FAQ</a></li>
                </ul>
            </div>

            {{-- Column 4: Newsletter --}}
            <div class="flex flex-col gap-4">
                <h3 class="font-bold text-sm tracking-wider text-primary mb-2 uppercase">Newsletter</h3>
                <p class="text-sm text-gray-600 leading-relaxed mb-1">
                    Dapatkan tips pendakian dan promo sewa terbaru langsung ke email Anda.
                </p>
                <form action="#" class="flex mt-2">
                    <input type="email" placeholder="Email Anda" class="w-full px-4 py-2 text-sm border border-gray-400/60 rounded-l-md focus:outline-none focus:border-primary bg-transparent text-gray-700 placeholder:text-gray-500">
                    <button type="submit" class="bg-blue-300 hover:bg-blue-400 text-slate-800 font-semibold px-5 py-2 rounded-r-md transition-colors text-sm">
                        Join
                    </button>
                </form>
            </div>
            
        </div>

        {{-- Bottom Section: Copyright --}}
        <div class="border-t border-gray-400/40 pt-6 mt-4 flex flex-col md:flex-row justify-between items-center gap-4 text-xs font-medium text-gray-600">
            <p>&copy; 2026 Basecamp OutdoorMountaineering. All rights reserved.</p>
            <div class="flex gap-6">
                <span>Designed for the Peak</span>
                <span>Adventure Awaits</span>
            </div>
        </div>

    </div>
</footer>