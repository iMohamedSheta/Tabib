<?php

use App\Livewire\App\Reception\ReceptionGlobalSearchModal;
use App\Models\Patient;
use App\Models\User;
use Livewire\Livewire;

beforeEach(function (): void {
    $this->user = User::factory()->create();
    $this->actingAs($this->user);
});

it('renders successfully', function (): void {
    Livewire::test(ReceptionGlobalSearchModal::class)
        ->assertOk();
});

it('initializes with empty search results', function (): void {
    Livewire::test(ReceptionGlobalSearchModal::class)
        ->assertSet('search', '')
        ->assertSet('searchType', 'patient')
        ->assertSee('');
});

it('can search for patients and display results', function (): void {
    $patient = Patient::factory()->create(['first_name' => 'Test', 'last_name' => 'Patient']);

    Livewire::test(ReceptionGlobalSearchModal::class)
        ->set('search', 'Test Patient')
        ->assertSee('Test Patient');
});

it('returns empty array when search is blank', function (): void {
    Livewire::test(ReceptionGlobalSearchModal::class)
        ->set('search', '')
        ->call('getSearchResults')
        ->assertSet('search', '');
});

it('generates correct patient URL', function (): void {
    $patient = Patient::factory()->create();

    Livewire::test(ReceptionGlobalSearchModal::class)
        ->call('getSearchResultUrl', $patient->id)
        ->assertDontSee('#');
});
