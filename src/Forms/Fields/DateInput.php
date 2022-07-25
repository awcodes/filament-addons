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

    protected bool | Closure $isWithoutSeconds = false;

    protected string | Closure | null $format = null;

    protected DateTime | string | Closure | null $maxDate = null;

    protected DateTime | string | Closure | null $minDate = null;

    protected string | Closure | null $timezone = null;

    protected function setUp(): void
    {
        parent::setUp();

        $this->afterStateHydrated(function (DateInput $component, $state): void {
            if (!$state) {
                return;
            }

            $state = Carbon::parse($state);

            if ($this->hasTime()) {
                // $state = $state->toDateTimeLocalString();
                $state->setTimezone($component->getTimezone());
            } else {
                $state = $state->format('Y-m-d');
            }

            $component->state((string) $state);
        });

        $this->dehydrateStateUsing(static function (DateInput $component, $state) {
            if (blank($state)) {
                return null;
            }

            if (! $state instanceof CarbonInterface) {
                $state = Carbon::parse($state);
            }

            $state->shiftTimezone($component->getTimezone());
            $state->setTimezone(config('app.timezone'));

            return $state->format($component->getFormat());
        });

        $this->rule('date', static fn (DateInput $component): bool => !$component->hasTime());
    }

    public function timezone(string | Closure | null $timezone): static
    {
        $this->timezone = $timezone;

        return $this;
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

    public function withoutSeconds(bool | Closure $condition = true): static
    {
        $this->isWithoutSeconds = $condition;

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

    public function hasSeconds(): bool
    {
        return ! $this->isWithoutSeconds;
    }

    public function getTimezone(): string
    {
        return $this->evaluate($this->timezone) ?? config('app.timezone');
    }

    public function getFormat(): string
    {
        $format = $this->evaluate($this->format);

        if ($format) {
            return $format;
        }

        $format = 'Y-m-d';

        if (! $this->hasTime()) {
            return $format;
        }

        $format = $format ? "{$format} H:i" : 'H:i';

        if (! $this->hasSeconds()) {
            return $format;
        }

        return "{$format}:s";
    }
}
