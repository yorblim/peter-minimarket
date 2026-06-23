@props(['status'])

@if ($status)
    <div {{ $attributes->merge(['class' => 'fw-medium small text-warning']) }} style="color: #e65100 !important;">
        {{ $status }}
    </div>
@endif
