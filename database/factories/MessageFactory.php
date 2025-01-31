<?php

namespace Database\Factories;

use App\Enums\Message\MessageTypeEnum;
use App\Models\Organization;
use App\Models\Prompt;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Message>
 */
class MessageFactory extends Factory
{
	/**
	 * Define the model's default state.
	 *
	 * @return array<string, mixed>
	 */
	public function definition(): array
	{
		return [
			'message' => fake()->sentence(),
			'type' => MessageTypeEnum::QUESTION->value,
			'organization_id' => Organization::factory()->create()->id,
			'model_type' => Prompt::class,
			'model_id' => Prompt::factory()->create()->id,
		];
	}
}
