<?php

namespace FilamentAddons\Forms\Components;

use Closure;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\View;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\Component;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\TextInput;
use FilamentAddons\Forms\Components\FieldGroup;

class VimeoEmbed extends Component
{
    public static function make(string $field = 'vimeo'): View
    {
        return View::make('filament-addons::forms.components.vimeo-embed', ['field' => $field])
            ->schema([
                Hidden::make($field . '.embed_url'),
                TextInput::make($field . '.url')
                    ->label('URL')
                    ->reactive()
                    ->afterStateUpdated(function($get, $set, $component) use ($field) {
                        $set($field . '.embed_url', $component->getContainer()->getParentComponent()->getEmbedUrl($get('url'), $get('autoplay'), $get('title'), $get('byline'), $get('portrait')));
                    })
                    ->required(),
                Checkbox::make($field . '.responsive')
                    ->default(true)
                    ->reactive()
                    ->helperText('If video is not responsive, set width and height to the actual pixel dimensions the video should be. Default is 640x480.'),
                Group::make([
                    TextInput::make($field . '.width')
                    ->reactive()
                        ->default('16'),
                    TextInput::make($field . '.height')
                    ->reactive()
                        ->default('9'),
                ])->columns(['md' => 2]),
                Grid::make(['md' => 3])
                    ->schema([
                        Group::make([
                            Checkbox::make($field . '.autoplay')->default(false)->reactive(),
                            Checkbox::make($field . '.loop')->default(false)->reactive(),
                        ]),
                        Group::make([
                            Checkbox::make($field . '.show_title')->label('Title')->default(false)->reactive(),
                            Checkbox::make($field . '.byline')->default(false)->reactive(),
                        ]),
                        Group::make([
                            Checkbox::make($field . '.portrait')->default(false)->reactive(),
                        ]),
                    ]),
            ]);
    }

    public function getEmbedUrl(string $url, bool $autoplay = false, bool $title = false, bool $byline = false, bool $portrait = false): string
    {
        if (Str::of($url)->contains('/video/')) {
            return $url;
        }

        $matches = preg_match('/\.com\/([0-9]+)/gm', $url);

        if (!$matches || !$matches[1]) {
            return null;
        }

        $params = [
            'autoplay' => $autoplay ? 1 : 0,
            'loop' => $loop ? 1 : 0,
            'title' => $title ? 1 : 0,
            'byline' => $byline ? 1 : 0,
            'portrait' => $portrait ? 1 : 0,
        ];

        $outputUrl = "https://player.vimeo.com/video/{$matches[1]}?" . http_build_query($params);

        return outputUrl;
    }
}

