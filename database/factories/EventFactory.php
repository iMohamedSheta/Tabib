<?php

namespace Database\Factories;

use App\Models\Event;
use App\Models\Organization;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Event>
 */
class EventFactory extends Factory
{
    protected $model = Event::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => $this->faker->sentence,
            'start_at' => $this->faker->dateTimeBetween('now', '+1 week'),
            'end_at' => $this->faker->dateTimeBetween('+1 week', '+2 weeks'),
            'all_day' => $this->faker->boolean,
            'data' => json_encode(['backgroundColor' => sprintf('#%06X', mt_rand(0, 0xFFFFFF)), 'overlap' => false]),
            'organization_id' => Organization::factory()->create()->id,
        ];
    }
}
