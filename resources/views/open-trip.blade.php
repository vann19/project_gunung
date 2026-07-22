<x-layouts.app title="Open Trip - {{ config('app.name') }}" description="Jelajahi paket open trip dan guide pendakian terbaik dari Basecamp Outdoors.">

    <x-open-trip.opentrip-section :trips="$trips ?? null" :guides="$guides ?? null" />
    <x-open-trip.pendaki-bergabung />

</x-layouts.app>