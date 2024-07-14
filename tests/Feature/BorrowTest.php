<?php

namespace Tests\Feature;

use App\Domain\Book\Models\Book;
use App\Domain\Borrow\Models\Borrow;
use Tests\TestCase;
use App\Domain\Member\Models\Member;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Domain\Borrow\Repositories\IBorrowRepository;
use Illuminate\Support\Facades\DB;
use PharIo\Manifest\NoEmailAddressException;

class BorrowTest extends TestCase
{
    // use RefreshDatabase;
    /**
     * A basic test example.
     */

    public function test_member_with_penalty_cannot_borrow_books(): void
    {
        // $member = Member::create([
        //     'code' => 'M001',
        //     'name' => 'Angga',
        //     'finalty' => true
        // ]);
        // $book = Book::create([
        //     'code' => 'NRN-7',
        //     'title' => 'The Lion, the Witch and the Wardrobe',
        //     'author' => 'C.S. Lewis',
        //     'stock' => 1
        // ]);
        $member = Member::where('code', '=', 'M001')->first();
        $response = $this->postJson('/api/borrow', [
            'member_code' => $member->code,
            'book_code' => 'NRN-7'
        ]);
        $response->assertStatus(403);
    }

    public function test_member_with_more_than_2_books(): void
    {
        $response = $this->postJson('/api/borrow', [
            'member_code' => 'M002',
            'book_code' => 'HW-11',
        ]);
        $response->assertStatus(403);
    }
    public function test_already_borrowed_by_another_member()
    {
        // $member = Member::create([
        //     'code' => 'M003',
        //     'name' => 'Putri',
        //     'finalty' => false
        // ]);
        $response = $this->postJson('/api/borrow', [
            'member_code' => 'M003',
            'book_code' => 'HW-11',
        ]);
        $response->assertStatus(403);
    }
}
