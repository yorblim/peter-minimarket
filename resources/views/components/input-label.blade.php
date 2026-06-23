@props(['value'])

<label {{ $attributes->merge(['class' => 'form-label fw-medium small']) }}>
    {{ $value ?? $slot }}
</label>
