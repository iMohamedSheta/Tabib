<?php

use App\Enums\Message\MessageTypeEnum;
use App\Livewire\App\Ai\Prompt;
use App\Models\ClinicAdmin;
use App\Models\Message;
use App\Models\Organization;
use App\Models\Prompt as PromptModel;
use App\Models\User;
use Livewire\Livewire;

describe('Prompt [Livewire-Component]', function (): void {
    beforeEach(function (): void {
        $this->organization = Organization::factory()->create();

        // Create a ClinicAdmin user for the organization
        $this->user = User::factory()->create([
            'organization_id' => $this->organization->id,
            'role' => ClinicAdmin::class,
        ]);

        // Create a ClinicAdmin model linked to the created user
        $this->clinicAdmin = ClinicAdmin::factory()->create([
            'organization_id' => $this->organization->id,
            'user_id' => $this->user->id,
        ]);

        $this->actingAs($this->user);
    });

    it('mounts with welcome message and loads existing prompt messages', function (): void {
        $promptModel = PromptModel::factory()->create();
        Message::factory()->create([
            'model_id' => $promptModel->id,
            'type' => MessageTypeEnum::QUESTION->value,
            'message' => 'user question',
            'organization_id' => $this->organization->id,
            'model_type' => Prompt::class,
        ]);
        Message::factory()->create([
            'model_id' => $promptModel->id,
            'type' => MessageTypeEnum::ANSWER->value,
            'message' => 'ai response',
            'organization_id' => $this->organization->id,
            'model_type' => Prompt::class,
        ]);

        Livewire::test(Prompt::class)
            ->assertStatus(200);
    });
});
