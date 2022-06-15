<?php

namespace FilamentAddons\Forms\Components;

use Filament\Forms\Components\Group;
use Illuminate\Database\Eloquent\Model;
use Filament\Forms\Components\Placeholder;

class Timestamps
{
    public static function make(): Group
    {
        return Group::make()
            ->schema([
                Placeholder::make('created_at')
                    ->label('Created at')
                    ->content(fn (?Model $record): string => $record ? $record->created_at->diffForHumans() : '-')
                    ->columns(1),
                Placeholder::make('updated_at')
                    ->label('Modified at')
                    ->content(fn (?Model $record): string => $record ? $record->updated_at->diffForHumans() : '-')
                    ->columns(1),
            ])->columnSpan('full')->columns(2);
    }
}
