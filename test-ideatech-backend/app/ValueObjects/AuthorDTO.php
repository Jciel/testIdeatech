<?php

namespace App\ValueObjects;

use Illuminate\Contracts\Support\Arrayable;

class AuthorDTO implements Arrayable
{
    public function __construct(
        public ?string $firstName = null,
        public ?string $lastName = null,
        public ?\DateTime $birthday = null,
        public ?string $country = null,
        public ?string $biography = null,
        public ?string $id = null,
    ) {
    }

    public static function create(
        ?string $firstName = null,
        ?string $lastName = null,
        ?\DateTime $birthday = null,
        ?string $country = null,
        ?string $biography = null,
        ?string $id = null,
    ) {
        return new AuthorDTO($firstName, $lastName, $birthday, $country, $biography, $id);
    }

    public function toArray()
    {
        return array_filter([
            'firstName' => $this->firstName,
            'lastName' => $this->lastName,
            'birthday' => $this->birthday,
            'country' => $this->country,
            'biography' => $this->biography,
            'id' => $this->id
        ], fn ($value) => $value != null);
    }
}
