<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title') - {{ config('app.name', 'Basecamps Outdoor') }}</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=hanken-grotesk:400,600,700,800,900|jetbrains-mono:700" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="antialiased bg-slate-50 min-h-screen flex items-center justify-center p-6">
    <div class="max-w-md w-full text-center space-y-6">
        <div class="flex justify-center text-rose-500 animate-pulse">
            <svg class="w-32 h-32 drop-shadow-md" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                <path d="M0 0h24v24H0z" fill="none" />
                <path fill="currentColor" d="M12.713 16.713Q13 16.425 13 16t-.288-.712T12 15t-.712.288T11 16t.288.713T12 17t.713-.288m0-4Q13 12.425 13 12V8q0-.425-.288-.712T12 7t-.712.288T11 8v4q0 .425.288.713T12 13t.713-.288M12 22q-2.075 0-3.9-.788t-3.175-2.137T2.788 15.9T2 12t.788-3.9t2.137-3.175T8.1 2.788T12 2t3.9.788t3.175 2.137T21.213 8.1T22 12t-.788 3.9t-2.137 3.175t-3.175 2.138T12 22" />
            </svg>
        </div>
        
        <div class="space-y-2">
            <h1 class="text-7xl font-black tracking-tight text-slate-800 font-['Hanken_Grotesk']">
                @yield('code')
            </h1>
            <h2 class="text-xl md:text-2xl font-bold text-slate-700">
                @yield('message')
            </h2>
        </div>
        
        <p class="text-slate-500 text-sm md:text-base leading-relaxed px-4">
            @yield('description')
        </p>
        
        <div class="pt-6">
            <a href="{{ url('/') }}" class="inline-flex items-center justify-center gap-2 px-8 py-3.5 bg-slate-800 hover:bg-slate-900 text-white font-bold rounded-xl transition-all shadow-md hover:shadow-lg active:scale-95 font-['JetBrains_Mono'] text-sm tracking-wider uppercase">
                Kembali ke Beranda
            </a>
        </div>
    </div>
</body>
</html>
