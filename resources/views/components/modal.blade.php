@props(['id' => '', 'maxWidth' => '2xl'])

@php
$maxWidthClasses = match ($maxWidth) {
    'sm' => 'modal-sm',
    'md' => '',
    'lg' => 'modal-lg',
    'xl' => 'modal-xl',
    '2xl' => 'modal-xl',
    default => '',
};
@endphp

<div id="{{ $id }}" class="modal fade" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog {{ $maxWidthClasses }}">
        <div class="modal-content shadow">
            <div class="modal-body">
                {{ $slot }}
            </div>
        </div>
    </div>
</div>
