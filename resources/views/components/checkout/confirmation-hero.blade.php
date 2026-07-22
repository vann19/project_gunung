@props(['trip' => 'Rinjani Expedition'])

@php
    // Accept either a string title or a Trip model/object
    $tripTitle = is_object($trip) ? ($trip->title ?? 'Open Trip Expedition') : $trip;
    $tripImage = '/img/rinjani.png';
    if (is_object($trip) && !empty($trip->image)) {
        $img = $trip->image;
        $tripImage = str_starts_with($img, '/') ? $img : '/' . $img;
    }
@endphp

<div class="w-full px-6 lg:px-12 pt-12 pb-10">
    <div class="max-w-[1280px] mx-auto grid grid-cols-1 lg:grid-cols-5 gap-10 items-center">

            <div class="lg:col-span-3 flex flex-col items-start gap-3">
            <span class="text-primary text-xs font-bold font-['JetBrains_Mono'] uppercase tracking-widest">Langkah Terakhir</span>
            <h1 class="text-3xl lg:text-4xl font-bold text-gray-900">Konfirmasi Pendaftaran</h1>
            <p class="text-gray-500 text-lg leading-relaxed max-w-xl">
                Terima kasih telah memilih {{ $tripTitle }}. Silakan periksa kembali detail ekspedisi Anda dan selesaikan pembayaran untuk mengamankan slot Anda.
            </p>
        </div>

        <div class="lg:col-span-2">
                <div class="rounded-2xl border-4 border-primary overflow-hidden aspect-square max-w-sm mx-auto">
                <img src="{{ $tripImage }}" alt="{{ $tripTitle }}" class="w-full h-full object-cover" />
            </div>
        </div>
    </div>
</div>