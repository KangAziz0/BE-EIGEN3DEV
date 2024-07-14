<?php

namespace App\Domain\Book\Services;

interface BookServiceInterface
{
  public function getAll();
  public function getBookWithoutBorrowed();
}
