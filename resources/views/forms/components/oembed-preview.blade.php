@php
    $state = $getState();

    if ($state) {
        $styles = $state['responsive'] ? "aspect-ratio: {$state['width']} / {$state['height']}; width: 100%; height: auto;" : null;
        $params = [
            'autoplay' => $state['autoplay'] ? 1 : 0,
            'loop' => $state['loop'] ? 1 : 0,
            'title' => $state['show_title'] ? 1 : 0,
            'byline' => $state['byline'] ? 1 : 0,
            'portrait' => $state['portrait'] ? 1 : 0,
        ];
    }
@endphp

<x-forms::field-wrapper
    :id="$getId()"
    :label="$getLabel()"
    :label-sr-only="$isLabelHidden()"
    :helper-text="$getHelperText()"
    :hint="$getHint()"
    :hint-icon="$getHintIcon()"
    :required="$isRequired()"
    :state-path="$getStatePath()"
>
    <div x-data="{ state: $wire.entangle('{{ $getStatePath() }}') }">
        @if($state && $state['embed_url'])
        <iframe
            src="{{ $state['embed_url'] }}?{{ http_build_query($params) }}"
            width="{{ $state['responsive'] ? $state['width'] : ($state['width'] ?: '640') }}"
            height="{{ $state['responsive'] ? $state['height'] : ($state['height'] ?: '480') }}"
            frameborder="0"
            allow="autoplay; fullscreen; picture-in-picture"
            allowfullscreen
            style="{{ $styles }}"
        ></iframe>
        @endif
    </div>
</x-forms::field-wrapper>