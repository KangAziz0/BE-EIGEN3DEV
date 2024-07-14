<?php

namespace App\Domain\Book\Repositories;

interface BookRepositoryInterface
{
  public function getBook();
  public function getBookWithoutBeingBorrowed();
}
