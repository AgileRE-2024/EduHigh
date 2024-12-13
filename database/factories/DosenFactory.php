<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Dosen>
 */
class DosenFactory extends Factory
{

    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = \App\Models\Dosen::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            //
            'kbk_id' => $this->faker->randomElement([1, 2]),
            'user_id' => \App\Models\User::factory(),
            'nidn' => $this->faker->unique()->numerify('##########'),
            'role' => $this->faker->randomElement(['dosen', 'dosen_koordinator']),
        ];
    }
}
