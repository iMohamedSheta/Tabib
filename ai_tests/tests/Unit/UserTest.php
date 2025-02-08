<?php

use App\Models\ClinicAdmin;
use App\Models\Doctor;
use App\Models\Manager;
use App\Models\Organization;
use App\Models\Patient;
use App\Models\Receptionist;
use App\Models\User;

uses(Tests\TestCase::class)->in('Unit');

describe('User Model', function () {
    it('can get the full name attribute', function () {
        $user = User::factory()->create([
            'first_name' => 'John',
            'last_name' => 'Doe',
        ]);

        expect($user->fullname)->toBe('John Doe');
    });

    it('can check if the user is a clinic admin', function () {
        $user = User::factory()->create();
        $clinicAdmin = ClinicAdmin::factory()->create(['user_id' => $user->id, 'organization_id' => Organization::factory()->create()->id]);
        $user->role_type = ClinicAdmin::class;
        $user->role_id = $clinicAdmin->id;
        $user->save();

        expect($user->isClinicAdmin())->toBeFalse();

        $user->role_type = ClinicAdmin::class;
        $user->save();

        $user->refresh();

        expect($user->isClinicAdmin())->toBeTrue();
    });

    it('can check if the user is a doctor', function () {
        $user = User::factory()->create();
        $doctor = Doctor::factory()->create(['user_id' => $user->id, 'organization_id' => Organization::factory()->create()->id]);
        $user->role_type = Doctor::class;
        $user->role_id = $doctor->id;
        $user->save();

        expect($user->isDoctor())->toBeFalse();

        $user->role_type = Doctor::class;
        $user->save();
        $user->refresh();

        expect($user->isDoctor())->toBeTrue();
    });

    it('can check if the user is a patient', function () {
        $user = User::factory()->create();
        $patient = Patient::factory()->create(['user_id' => $user->id, 'organization_id' => Organization::factory()->create()->id]);
        $user->role_type = Patient::class;
        $user->role_id = $patient->id;
        $user->save();

        expect($user->isPatient())->toBeFalse();

        $user->role_type = Patient::class;
        $user->save();
        $user->refresh();

        expect($user->isPatient())->toBeTrue();
    });

    it('can check if the user is a receptionist', function () {
        $user = User::factory()->create();
        $receptionist = Receptionist::factory()->create(['user_id' => $user->id, 'organization_id' => Organization::factory()->create()->id]);
        $user->role_type = Receptionist::class;
        $user->role_id = $receptionist->id;
        $user->save();

        expect($user->isReceptionist())->toBeFalse();

        $user->role_type = Receptionist::class;
        $user->save();
        $user->refresh();

        expect($user->isReceptionist())->toBeTrue();
    });

    it('can check if the user is a manager', function () {
        $user = User::factory()->create();
        $manager = Manager::factory()->create(['user_id' => $user->id, 'organization_id' => Organization::factory()->create()->id]);
        $user->role_type = Manager::class;
        $user->role_id = $manager->id;
        $user->save();

        expect($user->isManager())->toBeFalse();

        $user->role_type = Manager::class;
        $user->save();
        $user->refresh();

        expect($user->isManager())->toBeTrue();
    });

    it('can apply a like search scope', function () {
        User::factory()->create(['first_name' => 'John', 'last_name' => 'Doe']);
        User::factory()->create(['first_name' => 'Jane', 'last_name' => 'Smith']);

        $results = User::likeIn(['first_name', 'last_name'], 'John')->get();
        expect($results)->toHaveCount(1);
        expect($results[0]->first_name)->toBe('John');

        $results = User::likeIn(['first_name', 'last_name'], 'Doe')->get();
        expect($results)->toHaveCount(1);
        expect($results[0]->last_name)->toBe('Doe');

        $results = User::likeIn(['first_name', 'last_name'], 'Jo')->get();

        expect($results)->toHaveCount(1);
        expect($results[0]->first_name)->toBe('John');

        $results = User::likeIn(['first_name', 'last_name'], 'NonExistingName')->get();
        expect($results)->toHaveCount(0);
    });

    it('has organization relationship', function () {
        $organization = Organization::factory()->create();
        $user = User::factory()->create(['organization_id' => $organization->id]);

        expect($user->organization)->toBeInstanceOf(Organization::class);
        expect($user->organization->id)->toBe($organization->id);
    });

    it('has clinicAdmin relationship', function () {
        $user = User::factory()->create();
        $clinicAdmin = ClinicAdmin::factory()->create(['user_id' => $user->id]);
        $user->role_type = ClinicAdmin::class;
        $user->role_id = $clinicAdmin->id;
        $user->save();

        expect($user->clinicAdmin)->toBeInstanceOf(ClinicAdmin::class);
        expect($user->clinicAdmin->id)->toBe($clinicAdmin->id);
    });

    it('has doctor relationship', function () {
        $user = User::factory()->create();
        $doctor = Doctor::factory()->create(['user_id' => $user->id]);
        $user->role_type = Doctor::class;
        $user->role_id = $doctor->id;
        $user->save();

        expect($user->doctor)->toBeInstanceOf(Doctor::class);
        expect($user->doctor->id)->toBe($doctor->id);
    });

    it('has patient relationship', function () {
        $user = User::factory()->create();
        $patient = Patient::factory()->create(['user_id' => $user->id]);
        $user->role_type = Patient::class;
        $user->role_id = $patient->id;
        $user->save();

        expect($user->patient)->toBeInstanceOf(Patient::class);
        expect($user->patient->id)->toBe($patient->id);
    });

    it('has receptionist relationship', function () {
        $user = User::factory()->create();
        $receptionist = Receptionist::factory()->create(['user_id' => $user->id]);
        $user->role_type = Receptionist::class;
        $user->role_id = $receptionist->id;
        $user->save();

        expect($user->receptionist)->toBeInstanceOf(Receptionist::class);
        expect($user->receptionist->id)->toBe($receptionist->id);
    });

    it('has manager relationship', function () {
        $user = User::factory()->create();
        $manager = Manager::factory()->create(['user_id' => $user->id]);
        $user->role_type = Manager::class;
        $user->role_id = $manager->id;
        $user->save();

        expect($user->manager)->toBeInstanceOf(Manager::class);
        expect($user->manager->id)->toBe($manager->id);
    });
});
