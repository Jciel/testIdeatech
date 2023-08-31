<?php

namespace Database\Factories;

use App\Models\Author;
use Illuminate\Database\Eloquent\Factories\Factory;

class AuthorFactory extends Factory
{
    protected $model = Author::class;

    public function definition(): array
    {
        return [
            'firstName' => $this->faker->unique()->firstName,
            'lastName' => $this->faker->unique()->lastName,
            'birthday' => $this->faker->dateTime(),
            'country' => $this->faker->country(),
            'biography' => $this->faker->text(500)
        ];
    }
}
