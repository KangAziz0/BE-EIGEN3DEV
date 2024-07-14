<?php

namespace Tests\Feature;

// use Illuminate\Foundation\Testing\RefreshDatabase;

use App\Domain\Borrow\Models\Borrow;
use App\Domain\Member\Models\Member;
use Carbon\Carbon;
use Tests\TestCase;

class ReturnTest extends TestCase
{
  /**
   * A basic test example.
   */
  public function test_borrowed_by_member(): void
  {
    $response = $this->postJson('/api/return', [
      'member_code' => 'M002',
      'book_code' => 'TW-11',
    ]);
    $response->assertStatus(200);
  }
  public function test_member_is_penalized_for_late_return()
  {
    // $member = Member::where('code', 'M003')->first();
    // Simulasikan peminjaman buku
    $this->postJson('/api/borrow', [
      'member_code' => 'M003',
      'book_code' => 'JK-45',
    ]);

    // Simulasikan pengembalian buku setelah 8 hari
    Carbon::setTestNow(Carbon::now()->addDays(8));

    $response = $this->postJson('/api/return', [
      'member_code' => 'M003',
      'book_code' => 'JK-45',
    ]);
    $response->assertStatus(200);
  }
}
