<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\BookResource;
use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class BookController extends Controller
{
    public function index(){
        $book = Book::latest()->paginate(5);
        return new BookResource(true, 'List Data Book', $book);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'code'     => 'required',
            'title'   => 'required',
            'author'   => 'required',
            'stock'   => 'required',
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
