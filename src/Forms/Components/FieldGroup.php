<?php

namespace FilamentAddons\Forms\Components;

use Filament\Forms\Components\Component;
use Filament\Forms\Components\Concerns;
use Filament\Forms\Components\Contracts\CanEntangleWithSingularRelationships;

class FieldGroup extends Component implements CanEntangleWithSingularRelationships
{
    use Concerns\EntanglesStateWithSingularRelationship;

    protected string $view = 'filament-addons::forms.components.field-group';

    final public function __construct(string $label)
    {
        $this->label($label);
    }

    public static function make(string $label): static
    {
        $static = app(static::class, ['label' => $label]);
        $static->setUp();

        return $static;
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->columnSpan('full');

        $this->columns(2);
    }
}
