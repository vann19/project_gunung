@php
    $team = [
        [
            'photo'  => 'raka.png',
            'role'   => 'Head Guide',
            'name'   => 'Raka Wijaya',
            'quote'  => 'Puncak hanyalah bonus, kembali dengan selamat adalah kewajiban.',
            'traits' => [
                ['icon' => 'check', 'label' => 'Certified Alpine Guide (UIMLA)'],
                ['icon' => 'medal', 'label' => '15+ Years Experience'],
            ],
        ],
        [
            'photo'  => 'aris.png',
            'role'   => 'Lead Technician',
            'name'   => 'Aris Setiawan',
            'quote'  => 'Presisi pada alat adalah kunci ketenangan di medan ekstrem.',
            'traits' => [
                ['icon' => 'gear', 'label' => 'Gear Safety Specialist'],
                ['icon' => 'wrench', 'label' => '10+ Years Equipment Tech'],
            ],
        ],
    ];

    $traitIcons = [
        'check'  => '<svg class="w-4 h-4 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24"><circle cx="12" cy="12" r="9" stroke-width="2"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.5 12.5l2.5 2.5 4.5-5"/></svg>',
        'medal'  => '<svg class="w-4 h-4 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24"><circle cx="12" cy="9" r="5" stroke-width="2"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 13l-2 7 5-2 5 2-2-7"/></svg>',
        'gear'   => '<svg class="w-4 h-4 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24"><circle cx="12" cy="12" r="3" stroke-width="2"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.4 13a7.97 7.97 0 000-2l2-1.5-2-3.5-2.4 1a8 8 0 00-1.7-1L15 3h-6l-.3 2.5a8 8 0 00-1.7 1l-2.4-1-2 3.5L4.6 11a7.97 7.97 0 000 2l-2 1.5 2 3.5 2.4-1a8 8 0 001.7 1L9 21h6l.3-2.5a8 8 0 001.7-1l2.4 1 2-3.5-2-1.5z"/></svg>',
        'wrench' => '<svg class="w-4 h-4 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.7 6.3a4 4 0 00-5.4 5.4L4 17v3h3l5.3-5.3a4 4 0 005.4-5.4l-2.5 2.5-2-2 2.5-2.5z"/></svg>',
    ];
@endphp

<div class="w-full px-6 lg:px-12 py-16 lg:py-20">
    <div class="max-w-[1280px] mx-auto">

        <div class="flex flex-col sm:flex-row sm:items-end sm:justify-between gap-3 mb-10">
            <div>
                <h2 class="text-3xl lg:text-4xl font-bold text-gray-900 mb-2">Tim Ahli Kami</h2>
                <p class="text-gray-500">Para profesional di balik setiap pendakian yang sukses.</p>
            </div>
            <span class="text-gray-400 text-sm font-['JetBrains_Mono'] uppercase tracking-wide border-l-2 border-primary pl-3">
                Total Exp: 25+ Years
            </span>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
            @foreach ($team as $member)
                <div class="card p-6 flex flex-col sm:flex-row gap-5">
                    <img src="{{ asset('img/' . $member['photo']) }}" alt="{{ $member['name'] }}" class="w-full sm:w-28 h-40 sm:h-28 rounded-xl object-cover flex-shrink-0" />

                    <div class="flex flex-col gap-1.5">
                        <span class="text-primary text-[10px] font-bold font-['JetBrains_Mono'] uppercase tracking-widest">{{ $member['role'] }}</span>
                        <h3 class="text-xl font-bold text-gray-900">{{ $member['name'] }}</h3>
                        <p class="text-gray-500 text-sm italic leading-6 mb-1">&ldquo;{{ $member['quote'] }}&rdquo;</p>

                        <div class="flex flex-col gap-1.5">
                            @foreach ($member['traits'] as $trait)
                                <span class="flex items-center gap-2 text-gray-700 text-sm">
                                    {!! $traitIcons[$trait['icon']] !!}
                                    {{ $trait['label'] }}
                                </span>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>