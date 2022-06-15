<?php

namespace FilamentAddons\Forms\Components;

use Filament\Forms\Components\View;

class Separator
{
    public static function make(): View
    {
        return View::make('filament-addons::forms.components.separator');
    }
}
