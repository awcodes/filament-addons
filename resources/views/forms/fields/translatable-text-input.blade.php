<div class="flex flex-col gap-4">
    @foreach ($getChildComponents() as $group)
        <div x-data="{ locale: '{{ array_key_first($getLocales()) }}' }">
            @foreach ($group->getChildComponents() as $component)
                <div x-bind:style="locale != '{{ $component->locale }}' && { opacity: 0, height: 0, pointerEvents: 'none' }">
                    {{ $component }}
                </div>
            @endforeach
            <div class="relative flex items-center gap-2 mt-2">
                @foreach ($getLocales() as $key => $locale)
                    <button type="button" x-on:click="locale = '{{ $key }}'" class="px-2 text-sm border border-gray-600 rounded-md" :class="locale == '{{ $key }}' ? 'bg-gray-600' : 'bg-gray-800'">{{ $locale }}</button>
                @endforeach
            </div>
        </div>
    @endforeach
</div>
