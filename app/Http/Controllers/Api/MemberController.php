<?php

namespace App\Http\Controllers\Api;

use App\Domain\Member\Models\Member;
use App\Domain\Member\Services\IMemberService;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\MemberResource;
use Illuminate\Support\Facades\Validator;

class MemberController extends Controller
{

    protected $member;
    public function __construct(IMemberService $member)
    {
        $this->member = $member;
    }
    
    
    public function index()
    {
        
        $member = $this->member->getAll();
        return new MemberResource(true, 'Data Member', $member);
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
