<?php

namespace App\Http\Controllers\Api;


use App\Models\Member;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\MemberResource;

class MemberController extends Controller
{
    public function index(){
        $member = Member::latest()->paginate(5);
        return new MemberResource(true, 'List Data Member', $member);
    }
}
