<?php

namespace FilamentAddons\Forms\Components;

use Filament\Forms\Components\Component;

class Heading extends Component
{
    public string $level = 'h2';
    public string | Closure $content = '';

    final public function __construct()
    {
        $this->view('filament-addons::forms.components.heading');
    }

    public static function make(string $view): static
    {
        return app(static::class, ['heading-view' => $view]);
    }

    public function level(string $level): static
    {
        $this->level = $level;

        return $this;
    }

    public function content(string | Closure $content): static
    {
        $this->content = $content;

        return $this;
    }

    public function getLevel(): string
    {
        return $this->level;
    }

    public function getContent(): string
    {
        return $this->content;
    }
}