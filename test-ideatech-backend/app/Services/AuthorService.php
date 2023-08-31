<?php

namespace App\Services;

use App\Models\Author;
use App\ValueObjects\AuthorDTO;
use Illuminate\Database\Eloquent\Collection;

class AuthorService
{
    public function __construct(private Author $model)
    {
    }

    public function saveAuthor(AuthorDTO $author): Author
    {
        return $this->model::create($author->toArray());
    }

    public function listAllAuthors(): Collection
    {
        return $this->model::all();
    }

    public function getBy(AuthorDTO $attrs): Author
    {
        return $this->model::firstWhere($attrs->toArray());
    }

    public function updateAuthor(string $id, AuthorDTO $attrs): Author
    {
        $author = $this->model::find($id);
        $author->update($attrs->toArray());
        return $author;
    }

    public function deleteAuthor(string $id): Author
    {
        $author = $this->model::find($id);
        $author->delete();

        return $author;
    }

    public function search(string $query): Collection
    {
        return $this->model::where('firstName', 'LIKE', "%{$query}%")
            ->orWhere('lastName', 'LIKE', "%{$query}%")
            ->get();
    }
}
