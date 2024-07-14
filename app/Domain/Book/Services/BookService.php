<?php

namespace App\Domain\Book\Services;

use App\Domain\Book\Repositories\BookRepositoryInterface;

class BookService implements BookServiceInterface
{
  protected $bookRepository;
  public function __construct(BookRepositoryInterface $bookRepository)
  {
    $this->bookRepository = $bookRepository;
  }
  
  public function getAll()
  {
    return $this->bookRepository->getBook();
  }
  public function getBookWithoutBorrowed()
  {
    return $this->bookRepository->getBookWithoutBeingBorrowed();
  }
}
