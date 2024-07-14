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

    /**
     * @OA\Post(
     *     path="/api/borrow",
     *     operationId="PostBorrow",
     *     tags={"Borrow"},
     *     summary="Post Borrowing",
     *     description="Create a Borrowing",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"member_code","book_code"},
     *             @OA\Property(property="member_code", type="string", format="text", example="M002"),
     *             @OA\Property(property="book_code", type="string", format="text", example="SHR-1"),
     *         ),
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Borrowed successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Borrow Book is Successfuly"),
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Bad request"
     *     )
     * )
     */

    public function borrow(Request $request)
    {
        try {
            $this->borrowService->Borrowing($request->all());
            return response()->json(['message' => 'Borrow Book is Successfuly'], 200);
        } catch (ValidationException $e) {
            return response()->json(['message' => $e->errors()], 403);
        }
    }

      /**
     * @OA\Post(
     *     path="/api/return",
     *     operationId="PostReturnBook",
     *     tags={"Return"},
     *     summary="Post Return a Book",
     *     description="Return a Book",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"member_code","book_code"},
     *             @OA\Property(property="member_code", type="string", format="text", example="M002"),
     *             @OA\Property(property="book_code", type="string", format="text", example="SHR-1"),
     *         ),
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Borrowed successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Book returned successfuly."),
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Bad request"
     *     )
     * )
     */
    
    public function returnBook(Request $request)
    {
        try {
            $this->borrowService->returnBook($request->all());
            return response()->json(['message' => 'Book returned successfuly.'], 200);
        } catch (ValidationException $e) {
            return response()->json(['message' => $e->errors()], 422);
        }
    }

    /**
     * @OA\Get(
     *     path="/api/borrowed-books-count",
     *     operationId="GetBorrowedBookCount",
     *     tags={"Members"},
     *     summary="Get List Borrowed Book Count",
     *     description="Returns list  Borrowed Book Count",
     *     @OA\Response(
     *         response=200,
     *         description="Borrowed Books Count Success"
     *     )
     * )
     */
    
    
    public function getBorrowedBooksCount()
    {
        $result = $this->borrowService->getBorrowedBook();
        return new BorrowResource(true, 'Borrowed Books Count Success', $result);
    }
}
