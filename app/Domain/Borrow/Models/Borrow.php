<?php

namespace App\Domain\Borrow\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Borrow extends Model
{
    use HasFactory;
    protected $fillable = ['member_id','book_id'];
    // protected $dates = [
    //     'created_at',
    //     'updated_at',
    //     'returned_at',
    //     'borrowed_at'
    // ];
}
