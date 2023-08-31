<?php

namespace App\Http\Controllers;

use App\Services\BookService;
use App\ValueObjects\BookDTO;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class BookController extends Controller
{
    public function __construct(private BookService $bookService)
    {
    }

    public function index(Request $request): JsonResponse
    {
        try {
            return response()->json(
                $this->bookService->listAllBooks()->map(fn ($book) => $book->load("author")),
                Response::HTTP_OK
            );
        } catch (\Exception $e) {
            return $this->error($e->getMessage());
        }
    }

    public function create(Request $request): JsonResponse
    {
        try {
            $attrs = $this->mountDto($request);
            return response()->json($this->bookService->saveBook($attrs), Response::HTTP_OK);
        } catch (\InvalidArgumentException $e) {
            return $this->error($e->getMessage(), [], Response::HTTP_UNPROCESSABLE_ENTITY);
        } catch (\Exception $e) {
            return $this->error($e->getMessage());
        }
    }

    public function update(string $id, Request $request): JsonResponse
    {
        try {
            $attrs = $this->mountDto($request);
            return response()->json($this->bookService->updateBook($id, $attrs), Response::HTTP_OK);
        } catch (\Exception $e) {
            return $this->error($e->getMessage());
        }
    }

    public function delete(string $id): JsonResponse
    {
        try {
            return response()->json($this->bookService->deleteBook($id), Response::HTTP_OK);
        } catch (\Exception $e) {
            return $this->error($e->getMessage());
        }
    }

    public function search(string $query): JsonResponse
    {
        try {
            return response()->json($this->bookService->search($query), Response::HTTP_OK);
        } catch (\Exception $e) {
            return $this->error($e->getMessage());
        }
    }

    public function mountDto(Request $request): BookDTO
    {
        $publicationYear = null;
        if ($request->has('birthday')) {
            $publicationYear = new \DateTime($request->get('publicationYear'));
        }
        return BookDTO::create(
            title: $request->get('title'),
            gender: $request->get('gender'),
            synopsis: $request->get('synopsis'),
            cover: $request->get('cover'),
            publicationYear: $publicationYear,
            author_id: $request->get('author_id')
        );
    }
}
