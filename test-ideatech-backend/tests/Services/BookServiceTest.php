<?php

namespace Tests\Services;

use App\Models\Author;
use App\Models\Book;
use App\Services\BookService;
use App\ValueObjects\BookDTO;
use http\Exception\InvalidArgumentException;
use Illuminate\Database\QueryException;
use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;
use Tests\TestCase;

class BookServiceTest extends TestCase
{
    use DatabaseMigrations;
    use DatabaseTransactions;

    private BookService $bookService;

    public function setUp(): void
    {
        parent::setUp();

        $this->bookService = $this->app->make(BookService::class);
    }

    public function testSaveAnBook()
    {
        $author = Author::factory()->create();
        $attrs = new BookDTO(
            "Test save",
            "Fantasy",
            "Test",
            "12345",
            new \DateTime(),
            $author->id
        );

        $book = $this->bookService->saveBook($attrs);

        $this->seeInDatabase('books', ['title' => 'Test save']);
        $this->assertInstanceOf(Book::class, $book);
    }

    public function testSaveAnBookWithInvalidAttrs()
    {
        $attrs = new BookDTO();

        $this->expectException(\InvalidArgumentException::class);
        $this->bookService->saveBook($attrs);

        $this->notSeeInDatabase('short_links', ['identifier' => 'abc']);
    }

    public function testListAllBooks()
    {
        $author = Author::factory()->create();
        Book::factory(3)->create(['author_id' => $author->id]);

        $books = $this->bookService->listAllBooks();

        $this->assertCount(3, $books);
    }

    public function testGetAnBookByAttrs()
    {
        $author = Author::factory()->create();
        Book::factory()->createMany([
            ['title' => 'Test', 'author_id' => $author->id],
            ['title' => 'Testing', 'author_id' => $author->id],
            ['title' => 'Rain', 'author_id' => $author->id],
        ]);

        $attrs = BookDTO::create(title: 'Testing');

        $book = $this->bookService->getBy($attrs);

        $this->seeInDatabase('books', ['title' => 'Testing']);
        $this->assertInstanceOf(Book::class, $book);
    }

    public function testUpdateAnBook()
    {
        $author = Author::factory()->create();
        $book = Book::factory()->create([
            'title' => "Rain",
            'author_id' => $author->id
        ]);

        $this->seeInDatabase('books', ['title' => 'Rain']);

        $attrs = new BookDTO('Summer');

        $book = $this->bookService->updateBook($book->id, $attrs);

        $this->seeInDatabase('books', ['title' => 'Summer']);
        $this->assertInstanceOf(Book::class, $book);
    }

    public function testDeleteAnBook()
    {
        $author = Author::factory()->create();
        $book = Book::factory()->createMany([
            ['title' => 'Test', 'author_id' => $author->id],
            ['title' => 'Testing', 'author_id' => $author->id],
            ['title' => 'Rain', 'author_id' => $author->id],
        ])->firstOrFail()->first();

        $this->bookService->deleteBook($book->id);

        $this->assertCount(2, $book::all());
        $this->notSeeInDatabase('books', ['title' => 'Test']);
        $this->seeInDatabase('books', ['title' => 'Testing']);
        $this->seeInDatabase('books', ['title' => 'Rain']);
    }

    public function testSearchBooks()
    {
        $author = Author::factory()->create();
        Book::factory()->createMany([
            ['title' => 'Test', 'author_id' => $author->id],
            ['title' => 'Testing', 'author_id' => $author->id],
            ['title' => 'Rain', 'author_id' => $author->id],
        ]);

        $books = $this->bookService->search("Test");

        $this->assertCount(2, $books);
        $this->assertEquals("Test", $books[0]["title"]);
        $this->assertEquals("Testing", $books[1]["title"]);
    }
}
