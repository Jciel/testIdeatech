<?php

namespace Tests\Controllers;

use App\Models\Author;
use App\Models\Book;
use App\ValueObjects\BookDTO;
use Illuminate\Http\Response;
use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;
use Tests\TestCase;

class BookControllerTest extends TestCase
{
    use DatabaseTransactions;
    use DatabaseMigrations;

    public function setUp(): void
    {
        parent::setUp();
    }

    public function testRequestToListAllBooks()
    {
        Author::factory()->create();
        Book::factory(3)->create();

        $this->get("/v1/book/list");
        $this->assertResponseOk();

        $resArray = json_decode($this->response->getContent(), true);

        $this->assertCount(3, $resArray);
    }

    public function testRequestToCreateAnBook()
    {
        $author = Author::factory()->create();
        $data = [
            "title" => "Test save",
            "gender" => "Fantasy",
            "synopsis" => "Test",
            "cover" => "12345",
            "publicationYear" => new \DateTime(),
            "author_id" => $author->id
        ];

        $this->post("/v1/book/create", $data);

        $this->assertResponseOk();
        $resArray = json_decode($this->response->getContent(), true);
        $this->seeInDatabase('books', ['title' => 'Test save']);
        $this->assertEquals('Test save', $resArray['title']);
    }

    public function testRequestToCreateAnBookWithInvalidAttr()
    {
        $author = Author::factory()->create();
        $data = [
            "title" => "Test save",
            "gender" => "Fantasy",
            "synopsis" => "Test",
        ];

        $this->post("/v1/book/create", $data);
        $this->assertResponseStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        $this->notSeeInDatabase('books', ["title" => "Test save"]);
    }


    public function testRequestToUpdateAnBook()
    {
        $author = Author::factory()->create();
        $book = Book::factory()->create([
            'title' => "Rain",
            'author_id' => $author->id
        ]);

        $data = ["title" => "Test title"];

        $this->patch("/v1/book/update/{$book->id}", $data);
        $this->assertResponseOk();
        $this->seeInDatabase('books', ['title' => 'Test title']);
        $resArray = json_decode($this->response->getContent(), true);
        $this->assertEquals($data['title'], $resArray['title']);
    }

    public function testRequestToDeleteAnBook()
    {
        $author = Author::factory()->create();
        $book = Book::factory()->createMany([
            ['title' => 'Test', 'author_id' => $author->id],
            ['title' => 'Testing', 'author_id' => $author->id],
            ['title' => 'Rain', 'author_id' => $author->id],
        ])->firstOrFail()->first();

        $this->delete("/v1/book/delete/{$book->id}");
        $this->assertResponseOk();

        $this->assertCount(2, Book::all());
        $this->notSeeInDatabase('books', ['title' => 'Test']);
        $this->seeInDatabase('books', ['title' => 'Testing']);
        $this->seeInDatabase('books', ['title' => 'Rain']);
    }

    public function testRequestToSearchBooks()
    {
        $author = Author::factory()->create();
        Book::factory()->createMany([
            ['title' => 'Test', 'author_id' => $author->id],
            ['title' => 'Testing', 'author_id' => $author->id],
            ['title' => 'Rain', 'author_id' => $author->id],
        ]);

        $query = "Test";

        $this->get("/v1/book/search/{$query}");
        $this->assertResponseOk();

        $resArray = json_decode($this->response->getContent(), true);

        $this->assertCount(2, $resArray);
        $this->assertEquals("Test", $resArray[0]["title"]);
        $this->assertEquals("Testing", $resArray[1]["title"]);
    }
}
