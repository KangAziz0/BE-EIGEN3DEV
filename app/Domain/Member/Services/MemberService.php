<?php

namespace App\Domain\Member\Services;

use App\Domain\Member\Repositories\MemberRepositoryInterface;

class MemberService implements IMemberService
{
  protected $memberRepository;
  public function __construct(MemberRepositoryInterface $memberRepository)
  {
    $this->memberRepository = $memberRepository;
  }
  public function getAll()
  {
    return $this->memberRepository->getMember();
  }
}
