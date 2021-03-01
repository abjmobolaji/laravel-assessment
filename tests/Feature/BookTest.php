<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

use App\Models\Books;

class BookTest extends TestCase
{
    /**
     * Feature Test
     *
     * @return void
     */
    
    public function test_create_book_api()
    {
        $response = $this->post('/api/v1/books', [
                    "name" => "A Game of Cards",
                    "isbn" => "987-5363485",
                    "authors" => [ "Mobolaji Johnson"],
                    "number_of_pages" => 567,
                    "publisher" => "Mary Publishers",
                    "country" => "Serbia",
                    "release_date" => "2020-12-13"
        ], ['Accept' => 'application/json']);

        $response
            ->assertStatus(201)
            ->assertJson([
                'data' => true,
            ])
            ->assertJsonStructure([
                "status_code",
                "status",
                "data"
            ]);;
    }

    public function test_get_list_of_books()
    {
        $response = $this->get('/api/v1/books');

        $response
            ->assertStatus(200)
            ->assertJson([
                'data' => true,
            ])
            ->assertJsonStructure([
                "status_code",
                "status",
                "data"
            ]);
    }

    public function test_get_a_book()
    { 
        $book = Books::create([
            'name' => 'Eternal Books',
            'isbn'  => '987-0987865',
            'authors' => "Author Author",
            'publisher'  => "Mary Publishers",
            'number_of_pages' => 432,
            'country'  => "Ghana",
            'release_date' => "2013-09-12"
        ]);
        
        $response = $this->get('/api/v1/books/'.$book->id);

        $response
            ->assertStatus(200)
            ->assertJson([
                'data' => true,
            ])
            ->assertJsonStructure([
                "status_code",
                "status",
                "data"
            ]);
    }

    public function test_book_not_found()
    { 
        $book = Books::create([
            'name' => 'Eternal Books',
            'isbn'  => '987-0987865',
            'authors' => "Author Author",
            'publisher'  => "Mary Publishers",
            'number_of_pages' => 432,
            'country'  => "Ghana",
            'release_date' => "2013-09-12"
        ]);
        
        $response = $this->get('/api/v1/books/4000');

        $response
            ->assertStatus(404)
            ->assertJson([
                'message' => true,
            ])
            ->assertJsonStructure([
                "status_code",
                "status",
                "message",
                "data"
            ]);
    }

    public function test_update_a_book()
    {
        $book = Books::create([
            'name' => 'Eternal Books',
            'isbn'  => '987-0987865',
            'authors' => "Author Author",
            'publisher'  => "Mary Publishers",
            'number_of_pages' => 432,
            'country'  => "Ghana",
            'release_date' => "2013-09-12"
        ]);
        $response = $this->patch('/api/v1/books/'.$book->id,  [
                    "name" => "A Game of Cards",
                    "isbn" => "987-5363485",
                    "authors" => "Mobolaji Johnson",
                    "number_of_pages" => 567,
                    "publisher" => "Mary Publishers",
                    "country" => "Serbia",
                    "release_date" => "2013-08-09"
        ], ['Accept' => 'application/json']);

        $response
            ->assertStatus(200)
            ->assertJson([
                'data' => true,
            ])
            ->assertJsonStructure([
                "status_code",
                "status",
                "message",
                "data" 
            ]);
    }

    public function test_update_book_not_found()
    {
        $book = Books::create([
            'name' => 'Eternal Books',
            'isbn'  => '987-0987865',
            'authors' => "Author Author",
            'publisher'  => "Mary Publishers",
            'number_of_pages' => 432,
            'country'  => "Ghana",
            'release_date' => "2013-09-12"
        ]);
        $response = $this->patch('/api/v1/books/3',  [
                    "name" => "A Game of Cards",
                    "isbn" => "987-5363485",
                    "authors" => "Mobolaji Johnson",
                    "number_of_pages" => 567,
                    "publisher" => "Mary Publishers",
                    "country" => "Serbia",
                    "release_date" => "2013-08-09"
        ], ['Accept' => 'application/json']);

        $response
            ->assertStatus(404)
            ->assertJson([
                'message' => true,
            ])
            ->assertJsonStructure([
                "status_code",
                "status",
                "message",
                "data" 
            ]);
    }

    public function test_delete_a_book()
    {
        $book = Books::create([
            'name' => 'Eternal Books',
            'isbn'  => '987-0987865',
            'authors' => "Author Author",
            'publisher'  => "Mary Publishers",
            'number_of_pages' => 432,
            'country'  => "Ghana",
            'release_date' => "2013-09-12"
        ]);
        $response = $this->delete('/api/v1/books/'.$book->id);

        $response
            ->assertStatus(200);
    }
   
}