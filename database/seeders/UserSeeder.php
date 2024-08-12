<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
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
        User::factory()
        ->count(5)
        ->create();


    }
}
