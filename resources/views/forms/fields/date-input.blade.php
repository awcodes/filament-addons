<x-dynamic-component :component="$getFieldWrapperView()"
    :id="$getId()"
    :label="$getLabel()"
    :label-sr-only="$isLabelHidden()"
    :helper-text="$getHelperText()"
    :hint="$getHint()"
    :hint-icon="$getHintIcon()"
    :required="$isRequired()"
    :state-path="$getStatePath()">
    <div x-data="{
        isAutofocused: {{ $isAutofocused() ? 'true' : 'false' }},
        maxDate: '{{ $getMaxDate() }}',
        minDate: '{{ $getMinDate() }}',
        state: $wire.{{ $applyStateBindingModifiers('entangle(\'' . $getStatePath() . '\')') }},
        get theme() {
            return document.documentElement.classList.contains('dark') ? 'dark' : 'light';
        }
    }"
        {{ $attributes->merge($getExtraAttributes())->class(['relative filament-addons-date-input-component']) }}
        {{ $getExtraAlpineAttributeBag() }}>

        <input type="{{ $hasTime() ? 'datetime-local' : 'date' }}"
            placeholder="{{ $getPlaceholder() }}"
            x-bind:min="minDate"
            x-bind:max="maxDate"
            x-model="state"
            @if ($hasSeconds()) step="1" @endif
            pattern="[0-9]{4}-[0-9]{2}-[0-9]{2}T[0-9]{2}:[0-9]{2}(:[0-9]{2})?"
            {!! ($id = $getId()) ? "id=\"{$id}\"" : null !!}
            @class([
                'bg-white relative w-full border py-2 pl-3 pr-1 rtl:pl-1 rtl:pr-3 rounded-lg shadow-sm focus-within:border-primary-600 focus-within:ring-1 focus-within:ring-inset focus-within:ring-primary-600 w-full h-full placeholder-gray-400 focus:placeholder-gray-500 focus:ring-0 focus:outline-none',
                'dark:bg-gray-700 dark:placeholder-gray-400' => config('forms.dark_mode'),
                'border-gray-300' => !$errors->has($getStatePath()),
                'dark:border-gray-600' =>
                    !$errors->has($getStatePath()) && config('forms.dark_mode'),
                'border-danger-600' => $errors->has($getStatePath()),
                'text-gray-500' => $isDisabled(),
            ]) />
    </div>
</x-dynamic-component>
