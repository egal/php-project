<?php

namespace Egal\Core;

use Exception;

class TableMetadata
{

    use Arrayable;

    protected ModelMetadata $modelMetadata;
    protected array $fields;
    protected array $relations;
    protected array $filters;
    protected array $orders;
    protected array $roleAccesses;

    public static function make(ModelMetadata $modelMetadata): self
    {
        $tableMetadata = new self();
        $tableMetadata->modelMetadata = $modelMetadata;

        return $tableMetadata;
    }

    /**
     * @throws Exception
     */
    public function setFields(TableField ...$fields): self
    {
        foreach ($fields as $field) {
            // TODO: Проверить, что при эксепшене не будет заполняться дальше массив
            $this->fields[] = $this->modelMetadata->getFieldByName($field->getName());
        }

        return $this;
    }

    /**
     * @throws Exception
     */
    public function setRelations(TableRelation ...$relations):self
    {
        foreach ($relations as $relation) {
            // TODO: Проверить, что при эксепшене не будет заполняться дальше массив
            $this->relations[] = $this->modelMetadata->getRelationByName($relation->getName());
        }

        return $this;
    }

    public function setFilters(TableFilter ...$filters):self
    {
        $this->filters = $filters;

        return $this;
    }

    public function setOrders(TableOrder ...$orders):self
    {
        $this->orders = $orders;

        return $this;
    }

    public function setRoleAccesses(array $roles):self
    {
        $this->roleAccesses = $roles;

        return $this;
    }

    public function getFields(): array
    {
        return $this->fields;
    }

    public function getRelations(): array
    {
        return $this->relations;
    }

    public function getFilters(): array
    {
        return $this->filters;
    }

    public function getOrders(): array
    {
        return $this->orders;
    }

    public function getRoleAccesses(): array
    {
        return $this->roleAccesses;
    }
}