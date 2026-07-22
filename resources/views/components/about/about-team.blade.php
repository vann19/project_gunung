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

