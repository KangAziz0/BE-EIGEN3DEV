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
    /**
 * @OA\Info(
 *     title="My API",
 *     version="1.0.0",
 *     description="This is a sample API documentation",
 *     @OA\Contact(
 *         email="support@example.com"
 *     )
 * )
 */
    
    protected $book;

    public function __construct(BookServiceInterface $book)
    {
        $this->book = $book;
    }

  /**
     * @OA\Get(
     *     path="/api/books",
     *     operationId="GetBookList",
     *     tags={"Books"},
     *     summary="Get list of books",
     *     description="Returns list of books",
     *     @OA\Response(
     *         response=200,
     *         description="successful operation"
     *     )
     * )
     */
    public function index()
    {
        $books = $this->book->getAll();
        return new BookResource(true, 'List Data Book', $books);
    }

    /**
     * @OA\Get(
     *     path="/api/books-without-borrowed",
     *     operationId="GetBookWithoutBorrowed",
     *     tags={"Books"},
     *     summary="Get list of books without borrowed",
     *     description="Returns list of books without borrowed",
     *     @OA\Response(
     *         response=200,
     *         description="successful operation"
     *     )
     * )
     */
    
    
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
