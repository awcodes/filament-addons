<?php

namespace FilamentAddons\Forms\Fields;

use Illuminate\Support\Arr;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\Component;
use Filament\Forms\Components\Concerns\HasExtraAlpineAttributes;
use Filament\Forms\Components\Contracts\CanEntangleWithSingularRelationships;
use Filament\Forms\Components\Concerns\EntanglesStateWithSingularRelationship;

class TranslatableTextInput extends Component implements CanEntangleWithSingularRelationships
{
    use EntanglesStateWithSingularRelationship;
    use HasExtraAlpineAttributes;

    protected array $locales;

    protected string $view = 'filament-addons::forms.fields.translatable-text-input';

    final public function __construct(array $schema = [])
    {
        $this->locales = config('app.locales');
        $this->schema($schema);
    }

    public static function make(array $schema = []): static
    {
        $static = app(static::class, ['schema' => $schema]);
        $static->configure();

        return $static;
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->afterStateHydrated(function() {

            $modifiedSchema = [];
            foreach($this->getChildComponents() as $component) {
                $path = str_replace('data.', '', $component->getStatePath());

                $group = [];
                foreach ($this->locales as $k => $locale) {
                    $version = clone $component;
                    $version->statePath($path . '.' . $k);
                    $version->locale = $k;
                    array_push($group, $version);
                }
                array_push($modifiedSchema, Group::make($group));
            }

            $this->schema($modifiedSchema);
        });

    }

    public function getLocales(): array
    {
        return $this->locales;
    }
}
