<?php

namespace Egal\Core;

class InterfaceField extends AbstractInterfaceField
{
    protected ?array $computed;

    public function setComputed(array $computed): static
    {
        $this->computed = $computed;
        return $this;
    }

    public function getComputed(): array
    {
        return $this->computed;
    }

}