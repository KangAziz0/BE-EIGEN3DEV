<?php

namespace Tests\Feature;

// use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BookTest extends TestCase
{
    /**
     * A basic test example.
     */
    public function test_get_all_books(): void
    {
        $response = $this->getJson('/api/books');
        $response->assertStatus(200);
    }
    public function test_get_book_without_borrowed()
    {
        $response = $this->getJson('/api/books-without-borrowed');
        $response->assertStatus(200);
        // $data = $response->json('data');
        // dump($data);
    }
}
