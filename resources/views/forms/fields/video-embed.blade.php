<x-forms::field-wrapper :id="$getId()"
    :label="$getLabel()"
    :label-sr-only="$isLabelHidden()"
    :helper-text="$getHelperText()"
    :hint="$getHint()"
    :hint-icon="$getHintIcon()"
    :required="$isRequired()"
    :state-path="$getStatePath()">
    <div class="filament-addons-forms-video-embed">
        @if ($getState() != '')
            <div @class([
                'p-4 relative',
                'border-t border-x rounded-t-lg' => $getState(),
                'dark:border-gray-600 dark:bg-transparent dark:text-white' => config(
                    'forms.dark_mode'
                ),
                'border-gray-300 bg-gray-100' => !$errors->has($getStatePath()),
                'border-danger-600 ring-danger-600' => $errors->has($getStatePath()),
            ])>
                <h3 @class([
                    'absolute py-0.5 px-2 top-0 left-0 text-xs border-b border-r rounded-br',
                    'dark:border-gray-600 dark:text-white' => config('forms.dark_mode'),
                    'border-gray-300' => !$errors->has($getStatePath()),
                ])>Preview</h3>
                <div class="grid place-content-center">
                    {!! $getState() !!}
                </div>
            </div>
        @endif
        <textarea id="{{ $getId() }}"
            {!! $isAutofocused() ? 'autofocus' : null !!}
            {!! $isDisabled() ? 'disabled' : null !!}
            {!! $isRequired() ? 'required' : null !!}
            {!! ($rows = $getRows()) ? "rows=\"{$rows}\"" : null !!}
            {{ $applyStateBindingModifiers('wire:model') }}="{{ $getStatePath() }}"
            {{ $attributes->merge($getExtraAttributes())->merge($getExtraInputAttributeBag()->getAttributes())->class([
                    'font-mono block w-full transition duration-75 shadow-sm focus:border-primary-500 focus:ring-1 focus:ring-inset focus:ring-primary-600 filament-forms-textarea-component',
                    'rounded-lg' => !$getState(),
                    'rounded-b-lg' => $getState(),
                    'dark:bg-gray-700 dark:border-gray-600 dark:text-white' => config('forms.dark_mode'),
                    'border-gray-300' => !$errors->has($getStatePath()),
                    'border-danger-600 ring-danger-600' => $errors->has($getStatePath()),
                ]) }}
            @if ($shouldAutosize()) x-data="textareaFormComponent()"
                x-on:input="render()"
                style="height: 150px"
                {{ $getExtraAlpineAttributeBag() }} @endif>
        </textarea>
    </div>
    <p class="text-xs">Paste entire embed code into this field.</p>
</x-forms::field-wrapper>
