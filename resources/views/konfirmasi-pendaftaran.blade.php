<x-layouts.checkout :title="'Konfirmasi Pendaftaran - ' . config('app.name')" :nav-active="'trip'">

    <x-checkout.confirmation-hero :trip="$selectedTrip" />
    <x-checkout.confirmation-form :selected-trip="$selectedTrip" :all-trips="$allTrips" />

</x-layouts.checkout>