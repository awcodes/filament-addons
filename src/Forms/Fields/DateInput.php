<?php

namespace FilamentAddons\Forms\Fields;

use Carbon\Carbon;
use Closure;
use DateTime;
use Carbon\CarbonInterface;
use Filament\Forms\Components\Field;
use Illuminate\View\ComponentAttributeBag;
use Filament\Forms\Components\Concerns\HasPlaceholder;
use Filament\Forms\Components\Concerns\HasExtraAlpineAttributes;

class DateInput extends Field
{
    use HasExtraAlpineAttributes;
    use HasPlaceholder;

    protected string $view = 'filament-addons::forms.fields.date-input';

    protected array | Closure $extraTriggerAttributes = [];

    protected bool | Closure $isWithoutTime = false;

    protected DateTime | string | Closure | null $maxDate = null;

    protected DateTime | string | Closure | null $minDate = null;

    protected function setUp(): void
    {
        parent::setUp();

        $this->afterStateHydrated(function (DateInput $component, $state): void {
            if (!$state) {
                return;
            }

            $state = (new Carbon)::parse($state);

            if ($this->hasTime()) {
                $state = $state->toDateTimeLocalString();
            } else {
                $state = $state->format('Y-m-d');
            }

            $component->state($state);
        });

        $this->rule('date', true);
    }

    public function maxDate(DateTime | string | Closure | null $date): static
    {
        $this->maxDate = $date;

        $this->rule(function () use ($date) {
            $date = $this->evaluate($date);

            if ($date instanceof DateTime) {
                $date = $date->format('Y-m-d');
            }

            return "before_or_equal:{$date}";
        }, fn (): bool => (bool) $this->evaluate($date));

        return $this;
    }

    public function minDate(DateTime | string | Closure | null $date): static
    {
        $this->minDate = $date;

        $this->rule(function () use ($date) {
            $date = $this->evaluate($date);

            if ($date instanceof DateTime) {
                $date = $date->format('Y-m-d');
            }

            return "after_or_equal:{$date}";
        }, fn (): bool => (bool) $this->evaluate($date));

        return $this;
    }

    public function withoutTime(bool | Closure $condition = true): static
    {
        $this->isWithoutTime = $condition;

        return $this;
    }

    public function getMaxDate(): ?string
    {
        $date = $this->evaluate($this->maxDate);

        if ($date instanceof DateTime) {
            $date = $date->format($this->getFormat());
        }

        return $date;
    }

    public function getMinDate(): ?string
    {
        $date = $this->evaluate($this->minDate);

        if ($date instanceof DateTime) {
            $date = $date->format($this->getFormat());
        }

        return $date;
    }

    public function hasTime(): bool
    {
        return !$this->isWithoutTime;
    }
}
