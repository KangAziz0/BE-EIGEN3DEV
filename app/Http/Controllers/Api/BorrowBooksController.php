<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\BorrowResource;
use App\Models\Book;
use App\Models\Borrow;
use App\Models\Member;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class BorrowBooksController extends Controller
{
    public function borrow(Request $request)
    {
        $member = Member::where('code', $request->member_code)->first();
        $book = Book::where('code', $request->book_code)->first();

        if (!$member || !$book) {
            return response()->json(['message' => 'Invalid member or book.'], 400);
        }
        if ($member->penalty == true) {
            return response()->json(['message' => 'Member is under penalty.'], 403);
        }
        $borrowedBooksCount = DB::table('borrows')->where('member_id', $member->code)->count();
        if ($borrowedBooksCount >= 2) {
            return response()->json(['message' => 'Member cannot borrow more than 2 books.'], 403);
        }
        $isBookBorrowed = DB::table('borrows')->where('book_id', $book->code)->exists();
        if ($isBookBorrowed) {
            return response()->json(['message' => 'Book is already borrowed by another member.'], 403);
        }
        DB::transaction(function () use ($member, $book) {
            Book::where('code', $book->code)->update([
                'stock' => $book->stock - 1
            ]);
            DB::table('borrows')->insert([
                'member_id' => $member->code,
                'book_id' => $book->code,
                'borrowed_at' => now(),
            ]);
        });
        return response()->json(['message' => 'Borrow Book is Successfuly'], 200);
    }

    public function returnBook(Request $request)
    {
        $member = Member::where('code', $request->member_code)->first();
        $book = Book::where('code', $request->book_code)->first();

        if (!$member || !$book) {
            return response()->json(['message' => 'Invalid member or book.'], 400);
        }

        $borrow = DB::table('borrows')
            ->where('member_id', $member->code)
            ->where('book_id', $book->code)
            ->first();

        if (!$borrow) {
            return response()->json(['message' => 'No record of this book being borrowed by the member.'], 400);
        }

        DB::transaction(function () use ($member, $book, $borrow) {
            // Hapus data peminjaman
            DB::table('borrows')
                ->where('member_id', $member->code)
                ->where('book_id', $book->code)
                ->delete();

            // Tambahkan stok buku
            Book::where('code', $book->code)->update([
                'stock' => $book->stock + 1
            ]);
        });

        return response()->json(['message' => 'Book returned successfully.'], 200);
    }
    public function getBorrowedBooksCount()
    {
        $borrowedBooksCount = DB::table('borrows')
            ->select('member_id', DB::raw('count(*) as total'))
            ->groupBy('member_id')
            ->get();

        $result = $borrowedBooksCount->map(function ($item) {
            $member = Member::where('code',$item->member_id)->first();
            return [
                'member_id' => $item->member_id,
                'member_name' => $member->name,
                'total_borrowed_books' => $item->total
            ];
        });

        return response()->json($result, 200);
    }
}
