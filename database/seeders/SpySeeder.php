<?php

namespace Database\Seeders;

use app\Domain\Enums\Agency;
use App\Domain\Models\Spy;
use Illuminate\Database\Seeder;

class SpySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Spy::query()->create([
            'name' => 'James',
            'surname' => 'Bond',
            'agency' => Agency::MI6->value,
            'country_of_operation' => 'Great Britain',
            'date_of_birth' => '1960-01-01'
        ]);
        Spy::query()->create([
            'name' => 'Jason',
            'surname' => 'Bourne',
            'agency' => Agency::CIA->value,
            'country_of_operation' => 'U.S.A',
            'date_of_birth' => '1990-01-01'
        ]);
    }
}
