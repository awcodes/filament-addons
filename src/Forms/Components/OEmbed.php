<?php

namespace FilamentAddons\Forms\Components;

use Filament\Forms\Get;
use Filament\Forms\Set;
use Illuminate\Support\Str;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Group;
use Illuminate\Support\Facades\Http;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\Fieldset;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\ViewField;

class OEmbed
{
    public static function make(string $field = 'oembed'): Fieldset
    {
        return Fieldset::make($field)
            ->schema([
                Group::make([
                    Hidden::make($field . '.embed_url'),
                    Hidden::make($field . '.embed_type')
                        ->default('youtube'),
                    TextInput::make($field . '.url')
                        ->label('URL')
                        ->reactive()
                        ->lazy()
                        ->afterStateUpdated(function (Set $set, Get $get, $state) use ($field) {
                            if ($state) {
                                $video_url = urlencode($state);
                                $embed_type = Str::of($state)->contains('vimeo') ? 'vimeo' : 'youtube';
                                if ($embed_type == 'vimeo') {
                                    $embed_url = static::getVimeoUrl($state);
                                } else {
                                    $embed_url = static::getYoutubeUrl($state);
                                }
                                $set($field . '.embed_url', $embed_url);
                                $set($field . '.embed_type', $embed_type);
                            }
                        })
                        ->required()
                        ->columnSpan('full'),
                    Checkbox::make($field . '.responsive')
                        ->default(true)
                        ->reactive()
                        ->helperText('If video is not responsive, set width and height to the actual pixel dimensions the video should be. Default is 640x480.')
                        ->columnSpan('full'),
                    Group::make([
                        TextInput::make($field . '.width')
                            ->reactive()
                            ->required()
                            ->default('16'),
                        TextInput::make($field . '.height')
                            ->reactive()
                            ->required()
                            ->default('9'),
                    ])->columns(['md' => 2]),
                    Grid::make(['md' => 3])
                        ->schema([
                            Group::make([
                                Checkbox::make($field . '.autoplay')
                                    ->default(false)
                                    ->reactive(),
                                Checkbox::make($field . '.loop')
                                    ->default(false)
                                    ->reactive(),
                            ]),
                            Group::make([
                                Checkbox::make($field . '.show_title')
                                    ->label('Title')
                                    ->default(false)
                                    ->reactive(),
                                Checkbox::make($field . '.byline')
                                    ->default(false)
                                    ->reactive(),
                            ]),
                            Group::make([
                                Checkbox::make($field . '.portrait')
                                    ->default(false)
                                    ->reactive(),
                            ]),
                        ]),
                ]),
                ViewField::make($field)
                    ->view('filament-addons::forms.components.oembed-preview')
                    ->label('Preview'),
            ]);
    }

    public static function getVimeoUrl(string $url): string
    {
        if (Str::of($url)->contains('/video/')) {
            return $url;
        }

        preg_match('/\.com\/([0-9]+)/', $url, $matches);

        if (!$matches || !$matches[1]) {
            return '';
        }

        $outputUrl = "https://player.vimeo.com/video/{$matches[1]}";

        return $outputUrl;
    }

    public static function getYoutubeUrl(string $url): string
    {
        if (Str::of($url)->contains('/embed/')) {
            return $url;
        }

        preg_match('/v=([-\w]+)/', $url, $matches);

        if (!$matches || !$matches[1]) {
            return '';
        }

        $outputUrl = "https://www.youtube.com/embed/{$matches[1]}";

        return $outputUrl;
    }
}
