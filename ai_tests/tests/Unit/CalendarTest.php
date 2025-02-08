<?php

use App\Models\Calendar;
use App\Models\ClinicService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

uses(TestCase::class, RefreshDatabase::class);


describe('Calendar Model', function () {
    it('can create a calendar entry', function () {
        $calendar = Calendar::factory()->create();
        expect($calendar)->toBeInstanceOf(Calendar::class);
        $this->assertDatabaseHas('calendars', ['id' => $calendar->id]);
    });

    it('belongs to a ClinicService', function () {
        $clinicService = ClinicService::factory()->create();
        $calendar = Calendar::factory()->create(['clinic_service_id' => $clinicService->id]);

        expect($calendar->clinicServices())->toBeInstanceOf(Illuminate\Database\Eloquent\Relations\BelongsTo::class);
        expect($calendar->clinicServices->id)->toBe($clinicService->id);
    });

    it('can decode data attribute as an object', function () {
        $data = json_encode(['key1' => 'value1', 'key2' => 'value2']);
        $calendar = Calendar::factory()->create(['data' => $data]);

        $decodedData = $calendar->getDecodedDataAttribute();

        expect($decodedData)->toBeObject();
        expect($decodedData->key1)->toBe('value1');
        expect($decodedData->key2)->toBe('value2');
    });

    it('returns null for invalid json data', function () {
        $calendar = Calendar::factory()->create(['data' => 'invalid json']);

        expect($calendar->getDecodedDataAttribute())->toBeNull();
    });
});
