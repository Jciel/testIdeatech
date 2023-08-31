<?php

namespace App\Services;

use App\Models\Book;
use App\ValueObjects\BookDTO;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\QueryException;

class BookService
{
    public function __construct(private Book $model)
    {
    }

    /**
     * @throws \InvalidArgumentException
     */
    public function saveBook(BookDTO $book): Book
    {
        try {
            return $this->model::create($book->toArray());
        } catch (QueryException $e) {
            throw new \InvalidArgumentException("Invalid params arguments.");
        }
    }

    public function listAllBooks(): Collection
    {
        return $this->model::all();
    }

    public function getBy(BookDTO $attrs): Book
    {
        return $this->model::firstWhere($attrs->toArray());
    }

    public function updateBook(string $id, BookDTO $attrs): Book
    {
        $book = $this->model::find($id);
        $book->update($attrs->toArray());
        return $book;
    }

    public function deleteBook(string $id): Book
    {
        $book = $this->model::find($id);
        $book->delete();

        return $book;
    }

    public function search(string $query): Collection
    {
        return $this->model::where('title', 'LIKE', "%{$query}%")->get();
    }
}
