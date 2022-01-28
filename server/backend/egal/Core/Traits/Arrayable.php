<?php

namespace Egal\Core\Traits;

trait Arrayable
{

    public function toArray(): array
    {
        $result = [];
        foreach (array_keys(get_object_vars($this)) as $field) {
            $value = $this->{'get' . ucfirst($field)}();
            if (is_null($value)) {
                continue;
            }

            $result[$field] = $value;
        }

        return $result;
    }

}