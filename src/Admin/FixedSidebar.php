<?php

namespace FilamentAddons\Admin;

use Filament\Resources\Form;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Group;

class FixedSidebar
{
    public function __construct(public Form $form)
    {
    }

    public static function make(Form $form = null): static
    {
        if (!$form) {
            $form = Form::make();
        }

        return new static(form: $form);
    }

    public function schema(array $mainComponents, array $sidebarComponents): Form
    {
        return $this->form->schema([
            Group::make([
                Group::make($mainComponents),
                Group::make($sidebarComponents),
            ])->columnSpan('col-span-full fixed-sidebar')
        ]);
    }
}
