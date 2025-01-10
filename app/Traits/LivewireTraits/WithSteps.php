<?php

namespace App\Traits\LivewireTraits;

trait WithSteps
{
    public $step = 1;

    public $maxSteps = 2;

    public function backStep(): void
    {
        if ($this->step > 1) {
            $this->step--;
        }
    }

    public function nextStep(): void
    {
        if ($this->step < $this->maxSteps) {
            $this->step++;
        }
    }

    public function resetSteps(): void
    {
        $this->step = 1;
    }

    public function isLastStep(): bool
    {
        return $this->step === $this->maxSteps;
    }

    public function isFirstStep(): bool
    {
        return $this->step === 1;
    }
}
