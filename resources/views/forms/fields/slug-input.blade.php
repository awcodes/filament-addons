<x-forms::field-wrapper :id="$getId()"
    :label="$getLabel()"
    :label-sr-only="$isLabelHidden()"
    :helper-text="$getHelperText()"
    :hint="$getHint()"
    :hint-icon="$getHintIcon()"
    :required="$isRequired()"
    :state-path="$getStatePath()"
    class="-mt-3 filament-addons-slug-input-wrapper">
    <div x-data="{
        state: $wire.entangle('{{ $getStatePath() }}'),
        original: '',
        editing: false,
        init: function() { this.original = this.state; }
    }">
        <div
            {{ $attributes->merge($getExtraAttributes())->class(['flex items-center space-x-2 group filament-forms-text-input-component']) }}>
            <div class="text-sm">
                <strong>Permalink:</strong> {{ $getBaseUrl() }}<button type="button"
                    class="underline text-primary-500 hover:text-primary-600 focus:text-primary-600"
                    x-on:click="editing = true"
                    x-show="!editing">{{ $getState() }}</button><span x-show="!editing && state !== null">/</span>
            </div>
            <div class="flex-1"
                x-show="editing"
                style="display: none;">
                <input type="text"
                    x-model="original"
                    x-bind:disabled="!editing"
                    id="{{ $getId() }}"
                    {!! ($placeholder = $getPlaceholder()) ? "placeholder=\"{$placeholder}\"" : null !!}
                    {!! $isRequired() ? 'required' : null !!}
                    {{ $getExtraInputAttributeBag()->class(['block w-full transition duration-75 rounded-lg shadow-sm focus:border-primary-600 focus:ring-1 focus:ring-inset focus:ring-primary-600 disabled:opacity-70', 'dark:bg-gray-700 dark:text-white' => config('forms.dark_mode'), 'border-gray-300' => !$errors->has($getStatePath()), 'dark:border-gray-600' => !$errors->has($getStatePath()) && config('forms.dark_mode'), 'border-danger-600 ring-danger-600' => $errors->has($getStatePath())]) }} />
                <input type="hidden"
                    {{ $applyStateBindingModifiers('wire:model') }}="{{ $getStatePath() }}" />
            </div>
            <div x-show="editing"
                style="display: none;">
                <x-filament::button color="danger"
                    x-on:click="original = state; editing = false;">
                    <svg xmlns="http://www.w3.org/2000/svg"
                        class="w-5 h-5"
                        viewBox="0 0 20 20"
                        fill="currentColor">
                        <path fill-rule="evenodd"
                            d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                            clip-rule="evenodd" />
                    </svg>
                    <span class="sr-only">Cancel</span>
                </x-filament::button>
                <x-filament::button color="primary"
                    x-on:click="state = original; editing = false;">
                    <svg xmlns="http://www.w3.org/2000/svg"
                        class="w-5 h-5"
                        viewBox="0 0 20 20"
                        fill="currentColor">
                        <path fill-rule="evenodd"
                            d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                            clip-rule="evenodd" />
                    </svg>
                    <span class="sr-only">Save</span>
                </x-filament::button>
            </div>
        </div>
    </div>
</x-forms::field-wrapper>
