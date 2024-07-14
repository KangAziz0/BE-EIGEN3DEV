<?php

namespace App\Http\Controllers\Api;

use App\Domain\Book\Models\Book;
use App\Domain\Book\Services\BookServiceInterface;
use App\Http\Controllers\Controller;
use App\Http\Resources\BookResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class BookController extends Controller
{
    protected $book;

    public function __construct(BookServiceInterface $book)
    {
        $this->book = $book;
    }

    public function index()
    {
        $books = $this->book->getAll();
        return new BookResource(true, 'List Data Book', $books);
    }
    public function BookWithoutBorrowed()
    {
        $books = $this->book->getBookWithoutBorrowed();
        return new BookResource(true, 'List Data Book Without Borrowed', $books);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'code'     => 'required',
            'title'   => 'required',
            'author'   => 'required',
            'stock'   => 'required|number',
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $book = Book::create([
            'code'  => $request->code,
            'title'  => $request->title,
            'author'  => $request->author,
            'stock'   => $request->stock,
        ]);
        return new BookResource(true, 'Data Created', $book);
    }
}
