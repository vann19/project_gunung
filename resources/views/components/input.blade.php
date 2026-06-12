@props(['label' => null, 'name', 'type' => 'text', 'placeholder' => ''])

<div class="mb-4">
    @if($label)
        <label for="{{ $name }}" class="label">
            {{ $label }}
        </label>
    @endif
    
    <input 
        type="{{ $type }}" 
        name="{{ $name }}" 
        id="{{ $name }}" 
        placeholder="{{ $placeholder }}"
        {{ $attributes->merge(['class' => 'input']) }}
    >
    
    @error($name)
        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
    @enderror
</div>
