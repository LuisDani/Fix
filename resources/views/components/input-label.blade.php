@props(['value'])

<label {{ $attributes->merge(['class' => 'block font-black text-md text-black']) }}>
    {{ $value ?? $slot }}
</label>
