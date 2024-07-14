<?php

namespace App\Infrastructure\Book\Repositories;

use App\Domain\Book\Models\Book;
use App\Domain\Book\Repositories\BookRepositoryInterface;

class EloquentBookRepository implements BookRepositoryInterface
{
  public function getBook()
  {
    return Book::all();
  }
  public function getBookWithoutBeingBorrowed()
  {
    return Book::where('stock','!=',0)->get();
  }
}
