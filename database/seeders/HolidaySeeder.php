<?php

namespace Database\Seeders;

use App\Models\Holiday;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class HolidaySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Fornecedor::factory()
        //     ->count(5)
        //     ->hasProdutos(10)
        //     ->create();
        Holiday::factory()
        ->count(5)
        ->create();


    }
}
