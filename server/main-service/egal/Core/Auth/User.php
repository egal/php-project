<?php

namespace Egal\Core\Auth;

abstract class User
{

    private string|int $sub;

    public function getSub(): int|string
    {
        return $this->sub;
    }

}
