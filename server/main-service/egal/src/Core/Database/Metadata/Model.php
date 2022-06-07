<?php

namespace Egal\Core\Database\Metadata;

use Illuminate\Support\Str;

/**
 * #TODO: Регистрация обработчиков событий через метаданные.
 */
class Model
{

    private string $name;

    private string $class;

    private string $primaryKey = 'id';

    /**
     * @var Field[]
     */
    private array $fields = [];

    public static function make(string $class): self
    {
        $model = new self();
        $model->setClass($class);

        return $model;
    }

    private function setClass(string $class): self
    {
        # TODO: Check is class or not.
        $this->class = $class;
        $this->setNameFromClass($class);

        return $this;
    }

    private function setNameFromClass(string $class): self
    {
        $classExplode = explode('\\', $class);
        $this->setName(Str::snake(array_pop($classExplode)));

        return $this;
    }

    private function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function fields(Field ...$fields): self
    {
        $this->fields = array_merge($this->fields, $fields);

        return $this;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getPluralName(): string
    {
        return Str::plural($this->getName());
    }

    public function getClass(): string
    {
        return $this->class;
    }

    public function getValidationRules(): array
    {
        $result = [];

        foreach ($this->fields as $field) {
            $result[$field->getName()] = $field->getValidationRules();
        }

        return $result;
    }

    /**
     * @return string[]
     */
    public function getFillableFieldsNames(): array
    {
        $result = [];

        foreach ($this->fields as $field) {
            if ($field->isFillable()) {
                $result[] = $field->getName();
            }
        }

        return $result;
    }

    public function toArray(): array
    {
        return [
            'model_class' => $this->class,
            'model_short_name' => $this->name,
            'fields' => $this->fields,
//            'scopes' => $this->scopes
        ];
    }

}
