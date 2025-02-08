<?php

use App\Models\Doctor;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

beforeEach(function (): void {
    $this->user = User::factory()->create();
    $this->actingAs($this->user);
});

describe('Doctor Model', function () {
    it('can create a doctor', function () {
        $doctor = Doctor::factory()->create();

        expect($doctor)->toBeInstanceOf(Doctor::class);
        $this->assertDatabaseHas('doctors', ['id' => $doctor->id]);
    });

    it('deletes the associated user when deleting a doctor', function () {
        $doctor = Doctor::factory()->create();
        $userId = $doctor->user_id;

        $doctor->delete();

        $this->assertDatabaseMissing('doctors', ['id' => $doctor->id]);
        $this->assertDatabaseMissing('users', ['id' => $userId]);
    });

    it('has a user relationship', function () {
        $doctor = Doctor::factory()->create();

        expect($doctor->user())->toBeInstanceOf(Illuminate\Database\Eloquent\Relations\BelongsTo::class);
        expect($doctor->user)->toBeInstanceOf(User::class);
    });

    it('has a clinic relationship', function () {
        $doctor = Doctor::factory()->create();

        expect($doctor->clinic())->toBeInstanceOf(Illuminate\Database\Eloquent\Relations\BelongsTo::class);
    });
});
