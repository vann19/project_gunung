@props(['hover' => false])

@php
    $classes = $hover ? 'card-hover' : 'card';
@endphp

<div {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</div>
