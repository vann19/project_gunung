<x-layouts.app title="Beranda - {{ config('app.name') }}" description="Halaman Utama">
    
    {{-- Hero Section --}}
    <x-hero />
    <x-company />
    <x-rental :categories="$rentalCategories" />
    <x-layanan />
    <x-mulai />
    <x-mereka />
    

</x-layouts.app>
