<?php

use App\Traits\LivewireTraits\WithSteps;
use Livewire\Livewire;

class TestComponentWithSteps extends \Livewire\Component
{
    use WithSteps;

    public function render()
    {
        return <<<'HTML'
            <div>
                <h1>Step: {{$step}}</h1>
            </div>
        HTML;
    }
}

it('can navigate to the next step', function () {
    Livewire::component('test-component', TestComponentWithSteps::class);

    Livewire::test('test-component')
        ->assertSet('step', 1)
        ->call('nextStep')
        ->assertSet('step', 2);
});

it('cannot navigate beyond the maximum step', function () {
    Livewire::component('test-component', TestComponentWithSteps::class);

    Livewire::test('test-component')
        ->set('step', 2)
        ->call('nextStep')
        ->assertSet('step', 2);
});

it('can navigate to the previous step', function () {
    Livewire::component('test-component', TestComponentWithSteps::class);

    Livewire::test('test-component')
        ->set('step', 2)
        ->call('backStep')
        ->assertSet('step', 1);
});

it('cannot navigate before the first step', function () {
    Livewire::component('test-component', TestComponentWithSteps::class);

    Livewire::test('test-component')
        ->assertSet('step', 1)
        ->call('backStep')
        ->assertSet('step', 1);
});

it('can reset the steps to the initial state', function () {
    Livewire::component('test-component', TestComponentWithSteps::class);

    Livewire::test('test-component')
        ->set('step', 2)
        ->call('resetSteps')
        ->assertSet('step', 1);
});

it('correctly identifies the last step', function () {
    Livewire::component('test-component', TestComponentWithSteps::class);

    Livewire::test('test-component')
        ->set('step', 2)
        ->call('isLastStep')
        ->assertSet('step', 2)
        ->assertMethodWired('isLastStep', false);

    $component = Livewire::test('test-component')->instance();
    $component->step = $component->maxSteps;
    expect($component->isLastStep())->toBeTrue();
});

it('correctly identifies the first step', function () {
    Livewire::component('test-component', TestComponentWithSteps::class);

    $component = Livewire::test('test-component')->instance();
    expect($component->isFirstStep())->toBeTrue();

    $component->step = 2;
    expect($component->isFirstStep())->toBeFalse();
});
