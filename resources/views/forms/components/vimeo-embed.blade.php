@php
    $state = $getState();
    $styles = "aspect-ratio: aspectWidth / aspectHeight; width: 100%; height: auto;";
    ray($state);
@endphp
<div
    {!! $getId() ? "id=\"{$getId()}\"" : null !!}
    {{ $attributes->merge($getExtraAttributes())->class([
        'p-6 bg-white rounded-xl border border-gray-300 filament-forms-card-component',
        'dark:border-gray-600 dark:bg-gray-800' => config('forms.dark_mode'),
    ]) }}
>
    <div class="grid gap-6 md:grid-cols-2">
        <div>
            {{ $getChildComponentContainer() }}
        </div>
        <div>
            {{-- <iframe src="{{ $state[$field]['embed_url'] }}" width="640" height="360" frameborder="0" allow="autoplay; fullscreen; picture-in-picture" allowfullscreen></iframe> --}}
        </div>
    </div>
</div>
