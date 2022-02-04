<?php

namespace Egal\Core\Model\Metadata;

trait FieldTypeTrait
{
    protected string $type;

    public function string(): self
    {
        $this->type = 'string';

        return $this;
    }

    public function text(): self
    {
        $this->type = 'text';

        return $this;
    }

    public function getType(): string
    {
        return $this->type;
    }
}
