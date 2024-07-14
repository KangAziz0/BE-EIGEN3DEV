<?php

namespace Tests\Feature;

// use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class MemberTest extends TestCase
{
    /**
     * A basic test example.
     */
    public function test_get_data_members(): void
    {
        $response = $this->getJson('/api/members');
        $response->assertStatus(200);
        // $data = $response->json('data');
        // dump($data);
    }

    public function test_get_borrowed_books_count():void
    {
      $response = $this->getJson('/api/borrowed-books-count');
      $response->assertStatus(200);
      // $data = $response->json('data');
      // dump($data);
    }
}
