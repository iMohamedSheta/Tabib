<?php

use App\Models\Plan;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

describe('Plan Model', function () {
    it('can create a plan', function () {
        $plan = Plan::factory()->create();

        expect($plan)->toBeInstanceOf(Plan::class);
        $this->assertDatabaseHas('plans', ['id' => $plan->id]);
    });

    it('can be updated', function () {
        $plan = Plan::factory()->create();
        $new_name = 'Updated Plan Name';

        $plan->update(['name' => $new_name]);

        expect($plan->refresh()->name)->toBe($new_name);
        $this->assertDatabaseHas('plans', ['id' => $plan->id, 'name' => $new_name]);
    });

    it('can be deleted', function () {
        $plan = Plan::factory()->create();
        $id = $plan->id;

        $plan->delete();

        $this->assertDatabaseMissing('plans', ['id' => $id]);
    });
});
