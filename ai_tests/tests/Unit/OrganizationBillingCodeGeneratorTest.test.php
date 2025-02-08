<?php

use App\Generators\OrganizationBillingCodeGenerator;
use Illuminate\Support\Facades\DB;

uses(Tests\TestCase::class);

describe('OrganizationBillingCodeGenerator', function () {
    it('can generate a unique billing code', function () {
        $billingCode = OrganizationBillingCodeGenerator::generate();

        expect($billingCode)->toBeString();
        expect(strlen($billingCode))->toBe(6);
    });

    it('generates a unique billing code with a specific length', function () {
        $length = 8;
        $billingCode = OrganizationBillingCodeGenerator::generate($length);

        expect(strlen($billingCode))->toBe($length);
    });

    it('generates a billing code with a prefix and suffix', function () {
        $prefix = 'PREFIX_';
        $suffix = '_SUFFIX';
        $billingCode = OrganizationBillingCodeGenerator::generate(6, 5, 10, $prefix, $suffix);

        expect(strpos($billingCode, $prefix))->toBe(0);
        expect(substr($billingCode, -strlen($suffix)))->toBe($suffix);
    });

    it('retries generating a unique code if it already exists in the database', function () {
        $existingCode = '123456';

        DB::table('organizations')->insert(['billing_code' => $existingCode]);

        $generatedCode = OrganizationBillingCodeGenerator::generate();

        expect($generatedCode)->not()->toBe($existingCode);

        DB::table('organizations')->where('billing_code', $existingCode)->delete();
    });

    it('throws a RuntimeException if it cannot generate a unique code after maximum attempts', function () {
        $this->expectException(
            RuntimeException::class
        );

        OrganizationBillingCodeGenerator::generate(6, 5, 1);
    });
});
