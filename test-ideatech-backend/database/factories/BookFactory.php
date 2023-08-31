<?php

namespace Database\Factories;

use App\Models\Author;
use App\Models\Book;
use Illuminate\Database\Eloquent\Factories\Factory;

class BookFactory extends Factory
{
    protected $model = Book::class;

    public function definition(): array
    {
        return [
            'title' => $this->faker->sentence(),
            'gender' => $this->faker->title(),
            'synopsis' => $this->faker->text(500),
            'cover' => $this->faker->ean13(),
            'publicationYear' => $this->faker->dateTime(),
            'author_id' => Author::all()->random()->id
        ];
    }
}
