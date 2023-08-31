<?php

namespace Tests\Controllers;

use App\Models\Author;
use Illuminate\Http\Response;
use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;
use Tests\TestCase;

class AuthorControllerTest extends TestCase
{
    use DatabaseTransactions;
    use DatabaseMigrations;

    public function setUp(): void
    {
        parent::setUp();
    }

    public function testRequestToListAllAuthors()
    {
        Author::factory(3)->create();

        $this->get("/v1/author/list");
        $this->assertResponseOk();

        $resArray = json_decode($this->response->getContent(), true);

        $this->assertCount(3, $resArray);
    }

    public function testRequestToCreateAnAuthor()
    {
        $data = [
            'firstName' => "Joao",
            'lastName' => "Test",
            'birthday' => new \DateTime(),
            'country' => "Brasil",
            'biography' => "Testing"
        ];

        $this->post("/v1/author/create", $data);

        $this->assertResponseOk();
        $resArray = json_decode($this->response->getContent(), true);
        $this->seeInDatabase('authors', ['firstName' => 'Joao']);
        $this->assertEquals('Joao', $resArray['firstName']);
    }

    public function testRequestToCreateAnAuthorWithInvalidAttr()
    {
        $data = [
            'lastName' => "Test",
            'birthday' => new \DateTime(),
        ];

        $this->post("/v1/author/create", $data);
        $this->assertResponseStatus(Response::HTTP_INTERNAL_SERVER_ERROR);
        $this->notSeeInDatabase('authors', ["lastName" => "Test"]);
    }

    public function testRequestToUpdateAnAuthor()
    {
        $author = Author::factory()->create(['firstName' => 'Joao', 'lastName' => 'Test']);
        $this->seeInDatabase('authors', ['firstName' => 'Joao']);

        $data = [
            "firstName" => "Maria",
            "lastName" => 'Abacate'
        ];

        $this->patch("/v1/author/update/{$author->id}", $data);
        $this->assertResponseOk();
        $this->seeInDatabase('authors', ['firstName' => 'Maria']);

        $resArray = json_decode($this->response->getContent(), true);

        $this->assertEquals($data['firstName'], $resArray['firstName']);
        $this->assertEquals($data['lastName'], $resArray['lastName']);
    }

    public function testRequestToDeleteAnAuthor()
    {
        $author = Author::factory()->createMany([
            ['firstName' => 'Joao'],
            ['firstName' => 'Jose'],
            ['firstName' => 'Maria'],
        ])->firstOrFail()->first();

        $this->delete("/v1/author/delete/{$author->id}");
        $this->assertResponseOk();

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

        $this->get("/v1/author/search/{$query}");
        $this->assertResponseOk();

        $resArray = json_decode($this->response->getContent(), true);

        $this->assertCount(2, $resArray);
        $this->assertEquals("Joao", $resArray[0]["firstName"]);
        $this->assertEquals("Joaozinho", $resArray[1]["firstName"]);
    }
}
