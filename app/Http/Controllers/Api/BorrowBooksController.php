<?php

namespace App\Http\Controllers\Api;

use App\Domain\Borrow\Services\IBorrowService;
use App\Http\Controllers\Controller;
use App\Http\Resources\BorrowResource;
use App\Models\Book;
use App\Models\Borrow;
use App\Models\Member;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class BorrowBooksController extends Controller
{

    protected $borrowService;

    public function __construct(IBorrowService $borrow)
    {
        $this->borrowService = $borrow;
    }

    public function borrow(Request $request)
    {
        try {
            $this->borrowService->Borrowing($request->all());
            return response()->json(['message' => 'Borrow Book is Successfuly'], 200);
        } catch (ValidationException $e) {
            return response()->json(['message' => $e->errors()], 403);
        }
    }

    public function returnBook(Request $request)
    {
        try {
            $this->borrowService->returnBook($request->all());
            return response()->json(['message' => 'Book returned successfully.'], 200);
        } catch (ValidationException $e) {
            return response()->json(['message' => $e->errors()], 422);
        }
    }
    public function getBorrowedBooksCount()
    {
        $result = $this->borrowService->getBorrowedBook();
        return new BorrowResource(true, 'Borrowed Books Count', $result);
    }
}
