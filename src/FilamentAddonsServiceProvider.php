<?php

namespace FilamentAddons;

use Livewire\Livewire;
use Filament\Facades\Filament;
use Filament\PluginServiceProvider;
use Spatie\LaravelPackageTools\Package;

class FilamentAddonsServiceProvider extends PluginServiceProvider
{
    protected function getStyles(): array
    {
        $styles = config('filament-addons.load_styles') ? [
            'filament-addons-styles' => __DIR__ . '/../resources/dist/filament-addons.css',
        ] : [];
        return $styles;
    }

    public function configurePackage(Package $package): void
    {
        $package
            ->name('filament-addons')
            ->hasConfigFile()
            ->hasAssets()
            ->hasViews();
    }

    public function boot()
    {
        parent::boot();
    }
}
