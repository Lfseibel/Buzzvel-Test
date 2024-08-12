<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserFactory extends Factory
{
    /**
     * O nome do modelo associado à fábrica.
     *
     * @var string
     */
    protected $model = User::class;

    /**
     * Defina os estados padrão do modelo.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->name(),
            'email' => $this->faker->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password' => Hash::make('password'), // Senha padrão para todos os usuários
            'remember_token' => Str::random(10),
        ];
    }

    /**
     * Defina um estado de admin.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function admin()
    {
        return $this->state([
            'is_admin' => true,
        ]);
    }
}