@php
$state = $getFormattedState();
$statuses = $getStatuses();
$record = $getRecord();

$stateColor = match ($getStatusColor()) { 'danger' => \Illuminate\Support\Arr::toCssClasses(['text-danger-700 bg-danger-500/10', 'dark:text-danger-500' => config('tables.dark_mode')]),  'primary' => \Illuminate\Support\Arr::toCssClasses(['text-primary-700 bg-primary-500/10', 'dark:text-primary-500' => config('tables.dark_mode')]),  'success' => \Illuminate\Support\Arr::toCssClasses(['text-success-700 bg-success-500/10', 'dark:text-success-500' => config('tables.dark_mode')]),  'warning' => \Illuminate\Support\Arr::toCssClasses(['text-warning-700 bg-warning-500/10', 'dark:text-warning-500' => config('tables.dark_mode')]),  null => \Illuminate\Support\Arr::toCssClasses(['text-gray-700 bg-gray-500/10', 'dark:text-gray-300 dark:bg-gray-500/20' => config('tables.dark_mode')]),  default => $getStatusColor() };

@endphp

<div
    {{ $attributes->merge($getExtraAttributes())->class([
            'px-4 py-3 flex filament-addons-tables-title-with-status-column',
            match ($getAlignment()) {
                'left' => 'justify-start',
                'center' => 'justify-center',
                'right' => 'justify-end',
                default => null
            },
            'whitespace-normal' => $canWrap(),
        ]) }}>
    @if (filled($state))
        <div>
            {{ $state }}
            @if ($record->front_page)
                — <strong
                    class="px-2 py-1 text-xs rounded text-success-700 bg-success-500/10 dark:text-success-500">{{ __('Front Page') }}</strong>
            @elseif ($record->deleted_at)
                — <strong
                    class="px-2 py-1 text-xs text-gray-700 rounded bg-gray-500/10 dark:text-gray-300 dark:bg-gray-500/20">{{ __('Trashed') }}</strong>
            @elseif ($record->status !== $getHiddenOn())
                — <strong
                    class="px-2 rounded py-1 text-xs {{ $stateColor }}">{{ $statuses[$record->status] }}</strong>
            @endif
        </div>
    @endif
</div>
