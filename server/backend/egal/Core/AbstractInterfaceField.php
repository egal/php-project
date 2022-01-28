<?php

namespace Egal\Core;

use Exception;

abstract class AbstractInterfaceField
{
    protected string $label;
    protected string $type;

    /**
     * @param string $label
     * @param string $type
     */
    public function __construct(string $label, string $type)
    {
        $this->label = $label;
        $this->type = $type;
    }

    /**
     * @param $name
     * @param $arguments
     *
     * @return false|mixed
     * @throws Exception
     */
    public function __call($name, $arguments)
    {
        if (!preg_match('/^(set|get)(.+)$/', $name, $matches)) {
            throw new Exception('Method ' .  $name . ' does not exist in ' . static::class);
        }

        return call_user_func([$this, $matches[1]], lcfirst($matches[2]), $arguments);
    }

    /**
     * @param string $field
     * @param array $arguments
     *
     * @return $this
     * @throws Exception
     */
    protected function set(string $field, array $arguments) : self
    {
        if (!property_exists($this, $field)) {
            throw new Exception('Incorrect property ' . $field . ' in ' . static::class . '::set');
        }
        if (count($arguments) > 1) {
            throw new Exception('Incorrect argument count in ' . static::class . '::set');
        }
        $this->{$field} = $arguments[0];

        return $this;
    }

    /**
     * @param string $field
     *
     * @return mixed
     * @throws Exception
     */
    protected function get(string $field)
    {
        if (!property_exists($this, $field)) {
            throw new Exception('Incorrect property ' . $field . ' in ' . static::class . '::get');
        }

        return $this->{$field} ?? null;
    }

    /**
     * @return array
     * @throws Exception
     */
    public function toArray() : array
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