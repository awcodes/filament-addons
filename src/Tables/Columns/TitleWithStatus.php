<?php

namespace FilamentAddons\Tables\Columns;

use Filament\Tables\Columns\TextColumn;

class TitleWithStatus extends TextColumn
{
    protected string $view = 'filament-addons::tables.columns.title-with-status';

    protected string | null $hiddenOn = null;

    protected string | null $statusField = 'status';

    protected array | Arrayable | string | Closure | null $statuses = null;

    protected array | Closure $colors = [];

    public function statusField(string | null $statusField): static
    {
        $this->statusField = $statusField;

        return $this;
    }

    public function hiddenOn(string | null $hidden): static
    {
        $this->hiddenOn = $hidden;

        return $this;
    }

    public function statuses(array | Arrayable | string | Closure | null $statuses): static
    {
        $this->statuses = $statuses;

        return $this;
    }

    public function colors(array | Closure $colors): static
    {
        $this->colors = $colors;

        return $this;
    }

    public function getHiddenOn(): ?string
    {
        return $this->hiddenOn;
    }

    public function getStatuses(): array
    {
        $statuses = $this->evaluate($this->statuses);

        if ($statuses === null) {
            $statuses = $this->queriesRelationships() ? $this->getRelationshipOptions() : [];
        }

        if (is_string($statuses) && function_exists('enum_exists') && enum_exists($statuses)) {
            $statuses = collect($statuses::cases())->mapWithKeys(fn ($case) => [($case?->value ?? $case->name) => $case->name])->toArray();
        }

        if ($statuses instanceof Arrayable) {
            $statuses = $statuses->toArray();
        }

        return $statuses;
    }

    public function getStatusColor(): ?string
    {
        $record = $this->getRecord();
        $optionColor = null;

        foreach ($this->getColors() as $color => $condition) {
            if (is_numeric($color)) {
                $optionColor = $condition;
            } elseif ($condition instanceof Closure && $condition($state, $this->getRecord())) {
                $optionColor = $color;
            } elseif ($condition === $record->{$this->statusField}) {
                $optionColor = $color;
            }
        }

        return $optionColor;
    }

    public function getColors(): array
    {
        return $this->evaluate($this->colors);
    }
}
