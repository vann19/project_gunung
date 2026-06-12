@props(['variant' => 'primary', 'type' => 'button'])

@php
    $baseClasses = 'btn';
    
    $variants = [
        'primary' => 'btn-primary',
        'outline' => 'btn-outline',
        'ghost' => 'btn-ghost',
    ];

    $classes = $baseClasses . ' ' . ($variants[$variant] ?? $variants['primary']);
@endphp

<button type="{{ $type }}" {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</button>
