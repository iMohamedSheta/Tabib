<?php

use App\Enums\Ai\PromptTopicEnum;
use Illuminate\Support\Facades\Auth;

describe('PromptTopicEnum', function () {
    it('should return the correct topic options', function () {
        $expected = [
            PromptTopicEnum::PATIENT->value => 'المرضى',
            PromptTopicEnum::APPOINTMENT->value => 'المواعيد والحجوزات',
            PromptTopicEnum::INVOICE->value => 'الفواتير',
        ];

        expect(PromptTopicEnum::getTopicOptions())->toBe($expected);
    });

    it('should return the correct label for each case', function () {
        expect(PromptTopicEnum::PATIENT->label())->toBe('المرضى');
        expect(PromptTopicEnum::APPOINTMENT->label())->toBe('المواعيد والحجوزات');
        expect(PromptTopicEnum::INVOICE->label())->toBe('الفواتير');
    });

    it('should return the correct prompt for each case', function () {
        $patientPrompt = PromptTopicEnum::PATIENT->prompt();

        expect(PromptTopicEnum::APPOINTMENT->prompt())->toBe('المواعيد والحجوزات');
        expect(PromptTopicEnum::INVOICE->prompt())->toBe('الفواتير');
    });

    describe('getPatientPrompt', function () {
        beforeEach(function () {
            // Mocking Auth::check() and Auth::user() for testing purposes
            $this->mockedUser = Mockery::mock();
            $this->mockedAuth = Mockery::mock('alias:Illuminate\Support\Facades\Auth');
            $this->mockedCache = Mockery::mock('alias:Illuminate\Support\Facades\Cache');
            $this->mockedDB = Mockery::mock('alias:Illuminate\Support\Facades\DB');

            $this->mockedAuth->shouldReceive('check')->andReturn(true);
            $this->mockedAuth->shouldReceive('user')->andReturn($this->mockedUser);
            $this->mockedUser->shouldReceive('isClinicAdmin')->andReturn(true);
            $this->mockedUser->shouldReceive('getAttribute')->with('organization_id')->andReturn(1); // Mock organization_id
        });

        it('should return cached patient prompt when available', function () {
            $cacheKey = 'org_scoped_key';
            $cachedPrompt = 'cached patient prompt';

            $this->mockedCache->shouldReceive('generateOrgScopedKey')
                ->once()
                ->with('patient_prompt_query', PromptTopicEnum::class)
                ->andReturn($cacheKey);

            $this->mockedCache->shouldReceive('remember')
                ->once()
                ->with(
                    key: $cacheKey,
                    ttl: Mockery::type(DateTimeInterface::class),
                    callback: Mockery::type('Closure')
                )
                ->andReturn($cachedPrompt);

            $prompt = PromptTopicEnum::PATIENT->getPatientPrompt();

            expect($prompt)->toBe($cachedPrompt);
        });

        it('should return patient prompt from query when not cached', function () {
            $cacheKey = 'org_scoped_key';
            $dbResult = collect([
                (object) [
                    'pid' => 1,
                    'patient' => 'John. Doe',
                    'phone' => '1234567890',
                    'age' => 30,
                    'gender' => 'Male',
                    'puid' => 'puid123',
                    'eid' => 101,
                    'start' => '2024-01-01 10:00',
                    'end' => '2024-01-01 11:00',
                    'doctor' => 'Dr. Smith',
                ],
            ]);

            $expectedPrompt = '[{"id":1,"patient":"John. Doe","phone":"1234567890","age":30,"gender":"Male","event":{"id":101,"start":"2024-01-01 10:00","end":"2024-01-01 11:00","doctor":"Dr. Smith"}}]';

            $this->mockedCache->shouldReceive('generateOrgScopedKey')
                ->once()
                ->with('patient_prompt_query', PromptTopicEnum::class)
                ->andReturn($cacheKey);

            $this->mockedCache->shouldReceive('remember')
                ->once()
                ->with(
                    key: $cacheKey,
                    ttl: Mockery::type(DateTimeInterface::class),
                    callback: Mockery::type('Closure')
                )
                ->andReturnUsing(function ($key, $ttl, $callback) use ($dbResult) {
                    $this->mockedDB::shouldReceive('table')->with('patients as p')->andReturnSelf();
                    $this->mockedDB::shouldReceive('where')->with('p.organization_id', 1)->andReturnSelf();
                    $this->mockedDB::shouldReceive('join')->with('users as u', 'u.id', '=', 'p.user_id')->andReturnSelf();
                    $this->mockedDB::shouldReceive('join')->with('events as e', 'e.patient_id', '=', 'p.id')->andReturnSelf();
                    $this->mockedDB::shouldReceive('join')->with('doctors as d', 'd.id', '=', 'e.doctor_id')->andReturnSelf();
                    $this->mockedDB::shouldReceive('join')->with('users as du', 'du.id', '=', 'd.user_id')->andReturnSelf();
                    $this->mockedDB::shouldReceive('select')->with(Mockery::any())->andReturnSelf();
                    $this->mockedDB::shouldReceive('get')->andReturn($dbResult);

                    return $callback();
                });

            $prompt = PromptTopicEnum::PATIENT->getPatientPrompt();

            expect($prompt)->toBe($expectedPrompt);
        });
    });
});
