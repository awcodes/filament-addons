<?php

namespace FilamentAddons\Tables\Actions;

use Filament\Tables\Actions\Action;
use Illuminate\Database\Eloquent\Model;

class PublicViewAction extends Action
{
    public static function getDefaultName(): ?string
    {
        return 'viewPublicUrl';
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->label(__('View public url'));

        $this->color('secondary');

        $this->icon('heroicon-s-eye');

        $this->url(fn (Model $record): string => $record->getPublicUrl());

        $this->shouldOpenUrlInNewTab(true);
    }
}
