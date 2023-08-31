<?php

namespace App\ValueObjects;

use Illuminate\Contracts\Support\Arrayable;

class BookDTO implements Arrayable
{
    public function __construct(
        public ?string $title = null,
        public ?string $gender = null,
        public ?string $synopsis = null,
        public ?string $cover = null,
        public ?\DateTime $publicationYear = null,
        public ?string $author_id = null,
    ) {
    }

    public static function create(
        ?string $title = null,
        ?string $gender = null,
        ?string $synopsis = null,
        ?string $cover = null,
        ?\DateTime $publicationYear = null,
        ?string $author_id = null,
    ) {
        return new BookDTO($title, $gender, $synopsis, $cover, $publicationYear, $author_id);
    }

    public function toArray()
    {
        return array_filter([
            'title' => $this->title,
            'gender' => $this->gender,
            'synopsis' => $this->synopsis,
            'cover' => $this->cover,
            'publicationYear' => $this->publicationYear,
            'author_id' => $this->author_id
        ], fn ($value) => $value != null);
    }
}
