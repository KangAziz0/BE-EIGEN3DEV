<?php

namespace App\Domain\Member\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    use HasFactory;
    protected $fillable = ['code','name','finalty','finalty_end_at'];
}
