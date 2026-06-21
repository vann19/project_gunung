<div class="w-full px-6 lg:px-12 py-16 lg:py-20">
    <div class="max-w-[1280px] mx-auto grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">

        {{-- Kiri: Teks --}}
        <div class="flex flex-col gap-5">
            <h2 class="text-3xl lg:text-4xl font-bold text-gray-900">Cerita Kami</h2>
            <p class="text-gray-600 leading-relaxed">
                Basecamp Outdoor lahir dari kecintaan mendalam terhadap keheningan dan keagungan puncak gunung. Dimulai pada tahun 2018 oleh sekelompok pendaki berpengalaman, kami melihat kebutuhan akan akses peralatan berkualitas tinggi yang dapat diandalkan di kondisi ekstrem.
            </p>
            <p class="text-gray-600 leading-relaxed">
                Dari toko kecil di kaki gunung, kami berevolusi menjadi pusat perlengkapan teknis dan layanan pemandu profesional. Setiap peralatan yang kami sewakan dan setiap rute yang kami rencanakan adalah hasil dari ribuan jam pengalaman di lapangan.
            </p>
            <p class="text-gray-600 leading-relaxed">
                Bagi kami, pendakian bukan sekadar olahraga, melainkan sebuah perjalanan spiritual untuk mengenal diri sendiri melalui tantangan alam.
            </p>
        </div>

        {{-- Kanan: Foto + Overlay Card --}}
        <div class="relative rounded-2xl overflow-hidden aspect-[4/3]">
            <img src="{{ asset('img/Guide helping climber.png') }}" alt="Cerita Basecamp Outdoor" class="w-full h-full object-cover" />

            <div class="absolute bottom-5 left-5 right-5 sm:right-auto sm:max-w-[260px] bg-white/95 backdrop-blur-sm rounded-xl p-4 shadow-lg">
                <span class="block text-primary text-[10px] font-bold font-['JetBrains_Mono'] uppercase tracking-widest mb-1">Field Record</span>
                <span class="block text-gray-900 font-bold leading-snug">Gunung Rinjani, Indonesia</span>
                <span class="block text-gray-400 text-xs font-['JetBrains_Mono'] mt-1">ALT: 3726m</span>
            </div>
        </div>
    </div>
</div>