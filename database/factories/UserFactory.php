<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * The current password being used by the factory.
     */
    protected static ?string $password;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->firstName,
            'surname' => $this->faker->lastName,
            'password' => bcrypt('secret'), // Tüm kullanıcılar için aynı şifreyi kullanabilirsiniz, ya da her biri için farklı bir şifre oluşturabilirsiniz.
            'user_type' => $this->faker->randomElement(['admin', 'user']),
            'company_worker_count' => $this->faker->numberBetween(1, 500),
            'company_name' => $this->faker->company,
            'avatar_id' => 2,
            'token' => $this->faker->randomNumber(),
            'mail_api_key' => Str::random(10),
            'email' => $this->faker->unique()->safeEmail,
            'phone' => $this->faker->phoneNumber,
            'mail_activate' => $this->faker->boolean,
            'wp_activate' => $this->faker->boolean,
            'isAdmin' => '0',
            // 'email_verified_at' => now(),
            'remember_token' => Str::random(10),
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }
}
