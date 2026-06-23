@props(['active' => false])

@php
$classes = $active ? 'nav-link active fw-medium' : 'nav-link';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>{{ $slot }}</a>
