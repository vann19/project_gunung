<x-layouts.app title="Marketplace - {{ config('app.name') }}" description="Jual beli perlengkapan outdoor bekas berkualitas, terverifikasi oleh tim Basecamp Outdoors.">

    <x-marketplace.marketplace-hero />
    <x-marketplace.marketplace-listing :items="$items ?? null" />

</x-layouts.app>