<?php

namespace App\Domain\Borrow\Services;

interface IBorrowService
{
  public function Borrowing($data);
  public function returnBook($data);
  public function getBorrowedBook();
}
