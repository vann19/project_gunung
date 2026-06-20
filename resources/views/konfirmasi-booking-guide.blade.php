<x-layouts.checkout :title="'Konfirmasi Booking - ' . config('app.name')" :nav-active="'guide'">

    <x-guide-booking.guide-booking-header />

    <div class="w-full px-6 lg:px-12 pb-20">
        <div class="max-w-[1280px] mx-auto grid grid-cols-1 lg:grid-cols-5 gap-8 items-start">
            <x-guide-booking.guide-booking-form />
            <x-guide-booking.guide-booking-summary />
        </div>
    </div>

</x-layouts.checkout>