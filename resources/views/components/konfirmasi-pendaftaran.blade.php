<x-layouts.checkout :title="'Konfirmasi Pendaftaran - ' . config('app.name')" :nav-active="'trip'">

    <x-checkout.confirmation-hero :trip="'Rinjani Expedition'" />
    <x-checkout.confirmation-form />

</x-layouts.checkout>