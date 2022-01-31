<?php

namespace Egal\Core\Interface;

use Egal\Core\Traits\Arrayable;
use Exception;

class TableOrder
{
    use Arrayable;

    protected string $fieldName;
    protected string $direction;

    public static function make(string $fieldName, string $direction = 'asc'): self
    {
        $tableOrder = new self();
        $tableOrder->fieldName = $fieldName;

        if (in_array($direction, OrderByEnum::getAllOrders())) {
            $tableOrder->direction = $direction;

            return $tableOrder;
        }

        // TODO: Сделать эксепшн для этой ситуации
        throw new Exception();
    }

    public function getFieldName(): string
    {
        return $this->fieldName;
    }

    public function getDirection(): string
    {
        return $this->direction;
    }
}