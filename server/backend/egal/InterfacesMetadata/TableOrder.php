<?php

namespace Egal\Core\Interface;

use Egal\Core\Traits\Arrayable;
use Exception;

class TableOrder
{
    use Arrayable;

    protected string $fieldName;
    protected string $orderBy;

    public static function make(): self
    {
        return new self();
    }

    public function setFieldName(string $fieldName): self
    {
        $this->fieldName = $fieldName;

        return $this;
    }

    public function setOrderBy(string $orderBy): self
    {
        if (in_array($orderBy, OrderByEnum::getAllOrders())) {
            $this->orderBy = $orderBy;

            return $this;
        }

        // TODO: Сделать эксепшн для этой ситуации
        throw new Exception();
    }

    public function getFieldName(): string
    {
        return $this->fieldName;
    }

    public function getOrderBy(): string
    {
        return $this->orderBy;
    }
}