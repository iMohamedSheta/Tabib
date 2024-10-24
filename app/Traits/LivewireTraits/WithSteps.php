<?php

namespace App\Traits\LivewireTraits;

trait WithSteps
{
    public $step = 1;
    public $maxSteps = 2;

    public function backStep()
    {
        if ($this->step > 1) {
            $this->step--;
        }
    }

    public function nextStep()
    {
        if ($this->step < $this->maxSteps) {
            $this->step++;
        }
    }

    public function resetSteps()
    {
        $this->step = 1;
    }

    public function isLastStep()
    {
        return $this->step === $this->maxSteps;
    }

    public function isFirstStep()
    {
        return $this->step === 1;
    }
}
