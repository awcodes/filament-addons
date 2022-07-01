<?php

namespace FilamentAddons\Forms\Components;

use Closure;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\Component;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\View;
use FilamentAddons\Forms\Components\FieldGroup;

class YouTubeEmbed extends Component
{
    public static function make(string $field = 'youtube'): View
    {
        return View::make('filament-addons::forms.components.youtube-embed')
            ->schema([
                TextInput::make($field . '.url')
                    ->label('URL')
                    ->required(),
                Checkbox::make($field . '.responsive')
                    ->default(true)
                    ->helperText('If video is not responsive, set width and height to the actual pixel dimensions the video should be. Default is 640x480.'),
                Group::make([
                    TextInput::make($field . '.width')
                        ->default('16'),
                    TextInput::make($field . '.height')
                        ->default('9'),
                ])->columns(['md' => 2])
            ]);
    }
}

