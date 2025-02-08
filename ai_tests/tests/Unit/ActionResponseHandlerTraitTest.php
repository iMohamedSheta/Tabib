<?php

use App\Traits\LivewireTraits\ActionResponseHandlerTrait;
use Livewire\Volt\Component;

uses(Tests\TestCase::class);


describe('ActionResponseHandlerTrait', function () {
    beforeEach(function () {
        $this->component = new class extends Component {
            use ActionResponseHandlerTrait;

            public function matchStatus($actionResponseStatus = null): string
            {
                return parent::matchStatus($actionResponseStatus);
            }

            public function render(): string
            {
                return <<<'HTML'
                    <div></div>
                    HTML;
            }
        };
    });

    it('can use the trait', function () {
        expect(in_array(ActionResponseHandlerTrait::class, class_uses($this->component)))->toBeTrue();
    });

    describe('matchStatus', function () {
        it('returns success by default', function () {
            expect($this->component->matchStatus())->toBe('success');
        });

        it('returns the correct status based on input', function () {
            expect($this->component->matchStatus('success'))->toBe('success');
            expect($this->component->matchStatus('error'))->toBe('error');
            expect($this->component->matchStatus('warning'))->toBe('warning');
        });

        it('returns success if status does not match any condition', function () {
            expect($this->component->matchStatus('unknown'))->toBe('success');
        });
    });
});
