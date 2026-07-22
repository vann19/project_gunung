<x-layouts.checkout :title="'Konfirmasi Booking Guide - ' . config('app.name')" :nav-active="'guide'">

    <x-guide-booking.guide-booking-header />

    <x-guide-booking.guide-booking-form :selected-guide="$selectedGuide" :all-guides="$allGuides" />

</x-layouts.checkout>