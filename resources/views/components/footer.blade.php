<footer class="w-full bg-gradient-to-b from-white via-blue-50 to-[#CEECFF]">
    <div class="max-w-7xl mx-auto px-6 lg:px-12 py-12">
        {{-- Grid 4 kolom --}}
        <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
            
            {{-- Logo & Alamat --}}
            <div class="md:col-span-1">
                <a href="/">
                    <img src="{{ asset('img/logo.png') }}" alt="{{ config('app.name') }}" class="h-10 w-auto mb-4">
                </a>
                <p class="text-[#023A5C] text-xs leading-relaxed max-w-xs">
                    Jl. Pedak, Jaranan, Banguntapan, Kec. Banguntapan, Kabupaten Bantul, Daerah Istimewa Yogyakarta 55198
                </p>
            </div>

            {{-- Navigasi --}}
            <div>
                <h4 class="font-semibold text-sm uppercase tracking-wider mb-4 text-[#023A5C]">Navigasi</h4>
                <ul class="space-y-2 text-sm">
                    <li><a href="/" class="text-[#023A5C] hover:text-[#082265] transition-colors">Beranda</a></li>
                    <li><a href="/rental" class="text-[#023A5C] hover:text-[#082265] transition-colors">Rental Alat</a></li>
                    <li><a href="/service" class="text-[#023A5C] hover:text-[#082265] transition-colors">Service</a></li>
                    <li><a href="/contact" class="text-[#023A5C] hover:text-[#082265] transition-colors">Kontak</a></li>
                </ul>
            </div>

            {{-- Informasi --}}
            <div>
                <h4 class="font-semibold text-sm uppercase tracking-wider mb-4 text-[#023A5C]">Informasi</h4>
                <ul class="space-y-2 text-sm">
                    <li><a href="/privacy-policy" class="text-[#023A5C] hover:text-[#082265] transition-colors">Privacy Policy</a></li>
                    <li><a href="/terms-of-service" class="text-[#023A5C] hover:text-[#082265] transition-colors">Terms of Service</a></li>
                    <li><a href="/shipping-info" class="text-[#023A5C] hover:text-[#082265] transition-colors">Shipping Info</a></li>
                    <li><a href="/faq" class="text-[#023A5C] hover:text-[#082265] transition-colors">FAQ</a></li>
                </ul>
            </div>

            {{-- Newsletter --}}
            <div>
                <h4 class="font-semibold text-sm uppercase tracking-wider mb-4 text-[#023A5C]">Newsletter</h4>
                <p class="text-[#023A5C] text-sm mb-3">Dapatkan tips pendakian dan promo sewa terbaru langsung ke email Anda.</p>
                <div class="flex flex-col sm:flex-row gap-2">
                    <input type="email" placeholder="Email Anda" 
                        class="flex-1 px-3 py-2 rounded-md bg-white/30 border border-[#023A5C]/30 text-[#023A5C] placeholder-[#023A5C]/40 text-sm focus:outline-none focus:ring-2 focus:ring-[#023A5C]">
                    <button class="px-4 py-2 bg-[#023A5C] hover:bg-[#082265] rounded-md text-white font-semibold text-sm transition-colors whitespace-nowrap">
                        Join
                    </button>
                </div>
            </div>
        </div>

        {{-- Footer Bottom --}}
        <div class="mt-10 pt-6 border-t border-[#023A5C]/20 flex flex-col md:flex-row justify-between items-center gap-4 text-xs">
            <div class="flex flex-col md:flex-row items-center gap-2 text-center md:text-left text-[#1C1B1B]">
                <span>© 2026 Basecamp Outdoor Mountaineering. All rights reserved.</span>
            </div>
            <div class="flex flex-col md:flex-row items-center gap-2 text-center md:text-right text-[#1C1B1B]">
                <span>Designed for the Peak</span>
                <span class="hidden md:inline text-[#1C1B1B]">|</span>
                <span>Adventure Awaits</span>
            </div>
        </div>
    </div>
</footer>