<?php

namespace Database\Seeders;

use App\Models\Plan;
use Illuminate\Database\Seeder;

class PlanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $array = [
            [
                'name' => 'الخطة الافتراضية',
                'price' => 250,
            ],
            [
                'name' => 'الخطة الذهبية',
                'price' => 500,
            ],
        ];

        Plan::insert($array);
    }
}
