<?php

namespace FilamentAddons\Tables\Actions;

use Filament\Tables\Actions\Action;
use Illuminate\Database\Eloquent\Model;

class PreviewAction extends Action
{
    public static function getDefaultName(): ?string
    {
        return 'previewPublicUrl';
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->label(__('Preview'));

        $this->color('secondary');

        $this->icon('heroicon-s-eye');

        $this->url(fn (Model $record): string => $record->getPublicUrl());

        $this->shouldOpenUrlInNewTab(true);
    }
}
