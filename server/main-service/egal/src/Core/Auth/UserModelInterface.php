<?php

namespace Egal\Core\Auth;

interface UserModelInterface
{

    public function findBySub(string $sub): UserModelInterface;

    public function toAuthUser(): User;

}
