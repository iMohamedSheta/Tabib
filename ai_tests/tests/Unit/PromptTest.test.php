<?php

use App\Enums\Message\MessageTypeEnum;
use App\Models\Message;
use App\Models\Organization;
use App\Models\Prompt;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

uses(Tests\TestCase::class)->in('Unit');

beforeEach(function (): void {
    $this->organization = Organization::factory()->create();
    $this->user = User::factory()->create(['organization_id' => $this->organization->id]);
    Auth::setUser($this->user);
});

describe('Prompt Model', function () {
    it('can create a prompt', function () {
        $prompt = Prompt::create(['name' => 'Test Prompt']);

        expect($prompt)->toBeInstanceOf(Prompt::class);
        expect($prompt->name)->toBe('Test Prompt');
        expect($prompt->organization_id)->toBe($this->organization->id);
        $this->assertDatabaseHas('prompts', ['name' => 'Test Prompt', 'organization_id' => $this->organization->id]);
    });

    it('has messages relationship', function () {
        $prompt = Prompt::create(['name' => 'Test Prompt']);
        $message1 = Message::factory()->create(['model_id' => $prompt->id, 'model_type' => Prompt::class, 'type' => MessageTypeEnum::QUESTION->value]);
        $message2 = Message::factory()->create(['model_id' => $prompt->id, 'model_type' => Prompt::class, 'type' => MessageTypeEnum::ANSWER->value]);

        $messages = $prompt->messages;

        expect($messages)->toHaveCount(2);
        expect($messages->first())->toBeInstanceOf(Message::class);
        expect($messages->first()->id)->toBe($message1->id);
        expect($messages->last()->id)->toBe($message2->id);
    });

    it('can get ai context attribute', function () {
        $prompt = Prompt::create(['name' => 'Test Prompt']);
        Message::factory()->create(['model_id' => $prompt->id, 'model_type' => Prompt::class, 'type' => MessageTypeEnum::QUESTION->value, 'message' => 'Hello']);
        Message::factory()->create(['model_id' => $prompt->id, 'model_type' => Prompt::class, 'type' => MessageTypeEnum::ANSWER->value, 'message' => 'Hi']);
        Message::factory()->create(['model_id' => $prompt->id, 'model_type' => Prompt::class, 'type' => MessageTypeEnum::SYSTEM->value, 'message' => 'System Message']);

        $aiContext = $prompt->ai_context;

        expect($aiContext)->toBeArray();
        expect($aiContext)->toHaveCount(3);
        expect($aiContext[0]['type'])->toBe('user');
        expect($aiContext[0]['message'])->toBe('Hello');
        expect($aiContext[1]['type'])->toBe('ai');
        expect($aiContext[1]['message'])->toBe('Hi');
        expect($aiContext[2]['type'])->toBe('system');
        expect($aiContext[2]['message'])->toBe('System Message');
    });
});
