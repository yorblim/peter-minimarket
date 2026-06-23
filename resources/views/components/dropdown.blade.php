@props(['align' => 'right', 'width' => '48', 'contentClasses' => 'py-1 bg-white'])

@php
switch ($align) {
    case 'left':
        $alignmentClasses = 'start-0';
        break;
    case 'top':
        $alignmentClasses = 'bottom-0';
        break;
    case 'right':
    default:
        $alignmentClasses = 'end-0';
        break;
}

switch ($width) {
    case '48':
        $widthClasses = 'w-48';
        break;
}
@endphp

<div class="dropdown">
    <div data-bs-toggle="dropdown" aria-expanded="false" style="cursor: pointer;">
        {{ $trigger }}
    </div>

    <div class="dropdown-menu dropdown-menu-{{ $alignmentClasses }} {{ $widthClasses }} shadow">
        <div class="{{ $contentClasses }}">
            {{ $content }}
        </div>
    </div>
</div>
