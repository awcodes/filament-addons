<div {!! $getId() ? "id=\"{$getId()}\"" : null !!}
    {{ $attributes->merge($getExtraAttributes())->class(['filament-addons-forms-field-group-component', 'dark:text-gray-200' => config('forms.dark_mode')]) }}>
    {{ $getChildComponentContainer() }}
</div>
