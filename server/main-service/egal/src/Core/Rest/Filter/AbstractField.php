<?php

namespace Egal\Core\Rest\Filter;

abstract class AbstractField
{
    //TODO удалить класс, сделать наследование от филда релейшен филд
    abstract public static function fromString(string $fieldString): AbstractField;
}
