<?php

namespace App\Domain\Borrow\Services;

use App\Domain\Book\Models\Book;
use App\Domain\Borrow\Models\Borrow;
use App\Domain\Borrow\Repositories\IBorrowRepository;
use App\Domain\Member\Models\Member;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class BorrowService implements IBorrowService
{
  protected $borrowRepository;

  public function __construct(IBorrowRepository $borrow)
  {
    $this->borrowRepository = $borrow;
  }

  public function Borrowing($data)
  {
    $member = Member::where('code', $data['member_code'])->first();
    $book = Book::where('code', $data['book_code'])->first();

    if (!$member || !$book) {
      throw ValidationException::withMessages(['error' => 'Invalid member or book']);
    }
    if ($member->finalty == true) {
      throw ValidationException::withMessages(['error' => 'Member is under penalty']);
    }
    $borrowedBooksCount = DB::table('borrows')->where('member_id', $member->code)->count();
    if ($borrowedBooksCount >= 2) {
      throw ValidationException::withMessages(['error' => 'Member cannot borrow more than 2 books']);
    }
    $isBookBorrowed = DB::table('borrows')->where('book_id', $book->code)->exists();
    if ($isBookBorrowed) {
      throw ValidationException::withMessages(['error' => 'Book is already borrowed by another member']);
    }

    return $this->borrowRepository->borrow($data);
  }

  public function returnBook($data)
  {
    $member = Member::where('code', $data['member_code'])->first();
    $book = Book::where('code', $data['book_code'])->first();

    $borrowedBook = Borrow::where('book_id', $data['book_code'])->where('member_id', $data['member_code'])->first();
    if (!$borrowedBook) {
      throw ValidationException::withMessages(['error' => 'Invalid member or book']);
    }
    $borrowedBook->returned_at = date(now());
    $borrowedBook->save();
  
    $borrowedDays = $borrowedBook->created_at->diffInDays(Carbon::now());
    
    if ($borrowedDays > 7) {
      Member::where('code', $data['member_code'])->update([
        'finalty_end_at' => Carbon::now()->addDays(3),
        'finalty' => true
      ]);
    }

    $borrow = DB::table('borrows')
      ->where('member_id', $member->code)
      ->where('book_id', $book->code)
      ->first();

    if (!$borrow) {
      throw ValidationException::withMessages(['error' => 'No record of this book being borrowed by the member']);
    }

    return $this->borrowRepository->returnBook($data);
  }

  public function getBorrowedBook()
  {
    return $this->borrowRepository->getBorrowedBook();
  }
}
