<?php

namespace Tests\Services;

use App\Models\Author;
use App\Services\AuthorService;
use App\ValueObjects\AuthorDTO;
use Illuminate\Database\QueryException;
use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;
use Tests\TestCase;

class AuthorServiceTest extends TestCase
{
    use DatabaseMigrations;
    use DatabaseTransactions;

    private AuthorService $authorService;

    public function setUp(): void
    {
        parent::setUp();

        $this->authorService = $this->app->make(AuthorService::class);
    }

    public function testSaveAnAuthor()
    {
        $attrs = new AuthorDTO(
            "joao",
            "salvador",
            new \DateTime(),
            "Brasil",
            "Testando"
        );

        $author = $this->authorService->saveAuthor($attrs);

        $this->seeInDatabase('authors', ['firstName' => 'joao']);
        $this->assertInstanceOf(Author::class, $author);
    }

    public function testSaveAnAuthorWithInvalidAttrs()
    {
        $attrs = new AuthorDTO();

        $this->expectException(QueryException::class);
        $this->authorService->saveAuthor($attrs);

        $this->notSeeInDatabase('short_links', ['identifier' => 'abc']);
    }

    public function testListAllAuthors()
    {
        Author::factory(3)->create();

        $authors = $this->authorService->listAllAuthors();

        $this->assertCount(3, $authors);
    }

    public function testGetAnAuthorByAttrs()
    {
        Author::factory()->createMany([
            ['firstName' => 'Joao'],
            ['firstName' => 'Jose'],
            ['firstName' => 'maria'],
        ]);

        $attrs = AuthorDTO::create(firstName: 'Jose');

        $author = $this->authorService->getBy($attrs);

        $this->seeInDatabase('authors', ['firstName' => 'Jose']);
        $this->assertInstanceOf(Author::class, $author);
    }

    public function testUpdateAnAuthor()
    {
        $author = Author::factory()->create(['firstName' => 'Joao']);
        $this->seeInDatabase('authors', ['firstName' => 'Joao']);

        $attrs = new AuthorDTO('Maria');

        $author = $this->authorService->updateAuthor($author->id, $attrs);

        $this->seeInDatabase('authors', ['firstName' => 'Maria']);
        $this->assertInstanceOf(Author::class, $author);
    }

    public function testDeleteAnAuthor()
    {
        $author = Author::factory()->createMany([
            ['firstName' => 'Joao'],
            ['firstName' => 'Jose'],
            ['firstName' => 'Maria'],
        ])->firstOrFail()->first();

        $this->authorService->deleteAuthor($author->id);

        $this->assertCount(2, Author::all());
        $this->notSeeInDatabase('authors', ['firstName' => 'Joao']);
        $this->seeInDatabase('authors', ['firstName' => 'Jose']);
        $this->seeInDatabase('authors', ['firstName' => 'Maria']);
    }

    public function testSearchAuthor()
    {
        Author::factory()->createMany([
            ['firstName' => 'Joao'],
            ['firstName' => 'Joaozinho'],
            ['firstName' => 'Maria'],
        ]);

        $query = "Joao";

        $authors = $this->authorService->search($query);

        $this->assertCount(2, $authors);
        $this->assertEquals("Joao", $authors[0]["firstName"]);
        $this->assertEquals("Joaozinho", $authors[1]["firstName"]);
    }
}
