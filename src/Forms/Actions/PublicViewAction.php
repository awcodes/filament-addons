<?php

namespace FilamentAddons\Forms\Actions;

use Filament\Pages\Actions\Action;
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

        $this->label(__('View'));

        $this->color('secondary');

        $this->hidden(static function (Model $record): bool {
            if (!method_exists($record, 'trashed')) {
                return false;
            }

            return $record->trashed();
        });

        $this->url(static function ($record): string {
            return $record->getPublicUrl();
        });

        $this->shouldOpenUrlInNewTab(true);
    }
}
