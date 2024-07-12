<?php

namespace App\Http\Controllers\Api;


use App\Models\Member;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\MemberResource;
use Illuminate\Support\Facades\Validator;

class MemberController extends Controller
{
    public function index()
    {
        $member = Member::latest()->paginate(5);
        return new MemberResource(true, 'List Data Member', $member);
    }
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'code'     => 'required',
            'name'   => 'required|min:3',
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $member = Member::create([
            'code'  => $request->code,
            'name'   => $request->name,
        ]);
        return new MemberResource(true, 'Data Created', $member);
    }
}
