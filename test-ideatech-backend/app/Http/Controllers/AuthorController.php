<?php

namespace App\Http\Controllers;

use App\Services\AuthorService;
use App\ValueObjects\AuthorDTO;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class AuthorController extends Controller
{
    public function __construct(private AuthorService $authorService)
    {
    }

    public function index(Request $request): JsonResponse
    {
        try {
            return response()->json($this->authorService->listAllAuthors(), Response::HTTP_OK);
        } catch (\Exception $e) {
            return $this->error($e->getMessage());
        }
    }

    public function create(Request $request): JsonResponse
    {
        try {
            $attrs = $this->mountDto($request);
            return response()->json($this->authorService->saveAuthor($attrs), Response::HTTP_OK);
        } catch (\Exception $e) {
            return $this->error($e->getMessage());
        }
    }

    public function update(string $id, Request $request): JsonResponse
    {
        try {
            $attrs = $this->mountDto($request);
            return response()->json($this->authorService->updateAuthor($id, $attrs), Response::HTTP_OK);
        } catch (\Exception $e) {
            return $this->error($e->getMessage());
        }
    }

    public function delete(string $id): JsonResponse
    {
        try {
            return response()->json($this->authorService->deleteAuthor($id), Response::HTTP_OK);
        } catch (\Exception $e) {
            return $this->error($e->getMessage());
        }
    }

    public function search(string $query): JsonResponse
    {
        try {
            return response()->json($this->authorService->search($query), Response::HTTP_OK);
        } catch (\Exception $e) {
            return $this->error($e->getMessage());
        }
    }

    public function booksFromAuthor(string $id, Request $request): JsonResponse
    {
        try {
            $request->request->set('id', $id);
            $attrs = $this->mountDto($request);
            $author = $this->authorService->getBy($attrs);
            return response()->json($author->books->load('author'), Response::HTTP_OK);
        } catch (\Exception $e) {
            return $this->error($e->getMessage());
        }
    }

    /**
     * @throws \Exception
     */
    public function mountDto(Request $request): AuthorDTO
    {
        $birthday = null;
        if ($request->has('birthday')) {
            $birthday = new \DateTime($request->get('birthday'));
        }
        return AuthorDTO::create(
            firstName: $request->get('firstName'),
            lastName: $request->get('lastName'),
            birthday: $birthday,
            country: $request->get('country'),
            biography: $request->get('biography'),
            id: $request->get('id')
        );
    }
}
