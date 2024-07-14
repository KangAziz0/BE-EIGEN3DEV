<?php

namespace App\Infrastructure\Member\Repositories;

use App\Domain\Member\Models\Member;
use App\Domain\Member\Repositories\MemberRepositoryInterface;

class MemberRepository implements MemberRepositoryInterface
{
  public function getMember()
  {
    return  Member::latest()->paginate(5);
  }
}
