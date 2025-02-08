<?php

use App\Models\Invoice;
use App\Models\Organization;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

uses(TestCase::class, RefreshDatabase::class);

beforeEach(function (): void {
    $this->organization = Organization::factory()->create();
    $this->actingAs($this->organization->owner);
});

describe('Invoice', function () {
    it('can create an invoice', function () {
        $invoiceData = [
            'organization_id' => $this->organization->id,
            'amount' => 100,
            'description' => 'Test Invoice',
        ];

        $invoice = Invoice::create($invoiceData);

        expect($invoice)->toBeInstanceOf(Invoice::class);
        expect($invoice->organization_id)->toBe($this->organization->id);
        expect($invoice->amount)->toBe(100.0);
        expect($invoice->description)->toBe('Test Invoice');
        $this->assertDatabaseHas('invoices', $invoiceData);
    });

    it('can update an invoice', function () {
        $invoice = Invoice::factory()->create(['organization_id' => $this->organization->id]);

        $updatedData = [
            'amount' => 200,
            'description' => 'Updated Test Invoice',
        ];

        $invoice->update($updatedData);

        expect($invoice->amount)->toBe(200.0);
        expect($invoice->description)->toBe('Updated Test Invoice');
        $this->assertDatabaseHas('invoices', [
            'id' => $invoice->id,
            'amount' => 200,
            'description' => 'Updated Test Invoice',
        ]);
    });

    it('can delete an invoice', function () {
        $invoice = Invoice::factory()->create(['organization_id' => $this->organization->id]);

        $invoice->delete();

        $this->assertDatabaseMissing('invoices', ['id' => $invoice->id]);
    });

    it('applies organization scope', function () {
        $anotherOrganization = Organization::factory()->create();
        Invoice::factory()->create(['organization_id' => $this->organization->id]);
        Invoice::factory()->create(['organization_id' => $anotherOrganization->id]);

        $invoices = Invoice::all();

        expect($invoices)->toHaveCount(1);
        expect($invoices->first()->organization_id)->toBe($this->organization->id);
    });
});
