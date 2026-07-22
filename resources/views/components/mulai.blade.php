{{-- Section Mulai --}}
<div class="relative w-full h-screen md:h-[600px] overflow-hidden bg-white">
    <div class="relative z-10 flex flex-col justify-center items-center h-full px-6">
        <div class="relative w-full max-w-[1680px] rounded-3xl overflow-hidden shadow-2xl" style="background: linear-gradient(135deg, #082265, #1a4fa8);">
            <img src="img/siluet.png" alt="siluet gunung"
                 class="absolute -bottom-30 left-0 w-full h-auto object-cover opacity-50 pointer-events-none">
            <div class="relative z-10 flex flex-col items-center text-center px-8 py-20 md:px-24">
                <h2 class="text-3xl md:text-5xl font-bold text-white mb-6 leading-snug">
                    {{ __('home.mulai_title') }}
                </h2>
                <p class="text-white/75 text-sm md:text-lg leading-8 mb-10">
                    {!! nl2br(e(__('home.mulai_desc'))) !!}
                </p>
                <a href="https://wa.me/6281227387668" target="_blank"
                   class="flex items-center gap-2 bg-linear-to-b from-blue-300 to-sky-600 hover:from-blue-400 hover:to-sky-700 hover:scale-105 hover:shadow-lg text-white font-semibold px-6 py-3 rounded-full shadow-lg transition-all duration-300">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M20.52 3.48A11.93 11.93 0 0012.01 0C5.37 0 .01 5.37.01 12c0 2.11.55 4.17 1.6 5.99L0 24l6.18-1.62A11.94 11.94 0 0012.01 24c6.63 0 11.99-5.37 11.99-12 0-3.2-1.25-6.21-3.48-8.52zM12.01 22c-1.85 0-3.67-.5-5.24-1.44l-.38-.22-3.67.96.98-3.57-.25-.39A9.94 9.94 0 012 12C2 6.48 6.48 2 12.01 2c2.67 0 5.18 1.04 7.07 2.93A9.94 9.94 0 0122 12c0 5.52-4.48 10-9.99 10zm5.45-7.6c-.3-.15-1.77-.87-2.04-.97-.28-.1-.48-.15-.68.15-.2.3-.77.97-.94 1.17-.17.2-.35.22-.65.07-.3-.15-1.26-.46-2.4-1.47-.89-.79-1.49-1.76-1.66-2.06-.17-.3-.02-.46.13-.61.13-.13.3-.35.45-.52.15-.17.2-.3.3-.5.1-.2.05-.37-.02-.52-.07-.15-.68-1.63-.93-2.23-.24-.58-.49-.5-.68-.51h-.58c-.2 0-.52.07-.79.37-.27.3-1.04 1.01-1.04 2.47s1.07 2.87 1.22 3.07c.15.2 2.1 3.2 5.09 4.49.71.31 1.27.49 1.7.63.72.23 1.37.2 1.88.12.57-.09 1.77-.72 2.02-1.42.25-.7.25-1.3.17-1.42-.07-.12-.27-.2-.57-.35z"/>
                    </svg>
                    {{ __('home.mulai_cta') }}
                </a>
            </div>
        </div>
    </div>
</div>
