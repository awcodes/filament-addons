<?php

namespace FilamentAddons\Forms\Components;

use Closure;
use Illuminate\Support\Str;
use Filament\Forms\Components\Group;
use Illuminate\Database\Eloquent\Model;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Pages\EditRecord;
use Filament\Resources\Pages\CreateRecord;
use FilamentAddons\Forms\Fields\SlugInput;

class TitleWithSlug
{
    public static function make(string|null $title = 'title', string|null $slug = 'slug', string|Closure|null $basePath = '/'): Group
    {
        return Group::make()
            ->schema([
                TextInput::make($title)
                    ->required()
                    ->reactive()
                    ->disableLabel()
                    ->placeholder(fn () => Str::of($title)->title())
                    ->extraInputAttributes(['class' => 'text-2xl'])
                    ->afterStateUpdated(function ($state, Closure $set, $livewire) {
                        if ($livewire instanceof CreateRecord) {
                            return $set('slug', Str::slug($state));
                        }
                    }),
                SlugInput::make($slug)
                    ->mode(fn ($livewire) => $livewire instanceof EditRecord ? 'edit' : 'create')
                    ->disableLabel()
                    ->basePath($basePath)
                    ->required()
                    ->unique(ignorable: fn (?Model $record) => $record),
            ]);
    }
}
