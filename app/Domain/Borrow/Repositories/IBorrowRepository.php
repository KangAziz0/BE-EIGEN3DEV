<?php

namespace App\Domain\Borrow\Repositories;

interface IBorrowRepository
{
  public function borrow($data);
  public function returnBook($data);
  public function getBorrowedBook();
}
