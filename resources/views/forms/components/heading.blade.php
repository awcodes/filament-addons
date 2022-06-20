@php
$level = $getLevel()
@endphp

<{{ $level }}
    @class([
        'font-bold tracking-tight',
        'text-xl md:text-2xl' => $level == 'h2',
        'text-lg md:text-xl' => $level == 'h3',
        'text-default md:text-lg' => $level == 'h4',
        'text-default md:text-lg' => $level == 'h5',
        'text-default md:text-lg' => $level == 'h6',
    ])>
    {{ $getContent() }}
</{{ $level }}>