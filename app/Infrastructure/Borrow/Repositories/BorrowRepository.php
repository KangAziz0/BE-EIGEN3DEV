<?php

namespace App\Infrastructure\Borrow\Repositories;

use App\Domain\Book\Models\Book;
use App\Domain\Borrow\Models\Borrow;
use App\Domain\Borrow\Repositories\IBorrowRepository;
use App\Domain\Member\Models\Member;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class BorrowRepository implements IBorrowRepository
{
  public function borrow($data)
  {
    $member = Member::where('code', $data['member_code'])->first();
    $book = Book::where('code', $data['book_code'])->first();
    DB::transaction(function () use ($member, $book) {
      Book::where('code', $book->code)->update([
        'stock' => $book->stock - 1
      ]);
      Borrow::create([
        'member_id' => $member->code,
        'book_id' => $book->code,
        'borrowed_at' => date(now()),
      ]);
    });
  }

  public function returnBook($data)
  {
    $member = Member::where('code', $data['member_code'])->first();
    $book = Book::where('code', $data['book_code'])->first();
    DB::transaction(function () use ($member, $book) {
      // Hapus data peminjaman
      DB::table('borrows')
        ->where('member_id', $member->code)
        ->where('book_id', $book->code)
        ->delete();

      // Tambahkan stok buku
      Book::where('code', $book->code)->update([
        'stock' => $book->stock + 1
      ]);
    });
  }

  public function getBorrowedBook()
  {
    $borrowedBooksCount = DB::table('borrows')
      ->select('member_id', DB::raw('count(*) as total'))
      ->groupBy('member_id')
      ->get();

    $result = $borrowedBooksCount->map(function ($item) {
      $member = Member::where('code', $item->member_id)->first();
      return [
        'member_id' => $item->member_id,
        'member_name' => $member->name,
        'total_borrowed_books' => $item->total
      ];
    });
    return $result;
  }
}
