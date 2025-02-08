<?php

use App\Enums\Ai\PromptMessageEnum;
use App\Enums\Ai\PromptTopicEnum;
use App\Enums\Ai\SystemPromptEnum;
use App\Livewire\App\Ai\Prompt;
use App\Models\Prompt as PromptModel;
use Illuminate\Support\Str;
use Livewire\Livewire;

use function Pest\Laravel\assertDatabaseHas;

beforeEach(function (): void {
    $this->systemPrompt = SystemPromptEnum::DEFAULT->prompt() . "\n here is the conversation history: \n" . 'User: ' . SystemPromptEnum::AUTH->prompt() . "\n";
});

it('mounts successfully with initial data', function (): void {
    Livewire::test(Prompt::class)
        ->assertSee(PromptMessageEnum::WELCOME->prompt())
        ->assertSet('topics', PromptTopicEnum::getTopicOptions())
        ->assertSet('topicsChecked', [
            PromptTopicEnum::PATIENT->value => true,
        ]);
});

it('sends a prompt and creates a new PromptModel if none exists', function (): void {
    Livewire::test(Prompt::class)
        ->set('prompt', 'Test prompt')
        ->call('send')
        ->assertHasNoErrors()
        ->assertSet('prompt', '')
        ->assertNotNull('promptModel');

    $promptModel = PromptModel::latest()->first();
    expect($promptModel)->not->toBeNull();
    assertDatabaseHas('prompts', ['name' => Str::limit('Test prompt', 50)]);
});

it('sends a prompt and uses the existing PromptModel', function (): void {
    $promptModel = PromptModel::factory()->create();

    Livewire::test(Prompt::class)
        ->set('promptModel', $promptModel)
        ->set('prompt', 'Test prompt')
        ->call('send')
        ->assertHasNoErrors()
        ->assertSet('prompt', '');
});

it('validates prompt input', function (): void {
    Livewire::test(Prompt::class)
        ->set('prompt', '')
        ->call('send')
        ->assertHasErrors(['prompt' => 'required']);

    Livewire::test(Prompt::class)
        ->set('prompt', Str::random(2049))
        ->call('send')
        ->assertHasErrors(['prompt' => 'max']);
});

it('sets prompt model and updates messages', function (): void {
    $promptModel = PromptModel::factory()->create();

    Livewire::test(Prompt::class)
        ->call('setPromptModel', $promptModel->id)
        ->assertSet('promptModel', $promptModel);
});
