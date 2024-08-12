<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Fornecedor>
 */
class HolidayFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => $this->faker->text(8),
            'description' => $this->faker->text(100),
            'date' => $this->faker->date('Y-m-d'),
            'location' => $this->faker->streetAddress(),
            'participants' => $this->faker->name(),
        ];
    }
}
