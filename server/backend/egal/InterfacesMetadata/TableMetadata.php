<?php

namespace Egal\Core\Interface;

use Egal\Core\Model\Filter\FilterInterface;
use Egal\Core\Traits\Arrayable;
use Egal\Core\Model\Metadata\ModelMetadata;
use Exception;

class TableMetadata
{

    use Arrayable;

    protected ModelMetadata $modelMetadata;
    protected array $fields;
    protected array $relations;
    protected array $defaultFilters;
    protected array $defaultOrders;
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

    public function setDefaultFilter(FilterInterface ...$filters):self
    {
        $this->defaultFilters = $filters;

        return $this;
    }

    public function setDefaultOrders(TableOrder ...$orders):self
    {
        $this->defaultOrders = $orders;

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

    public function getDefaultFilters(): array
    {
        return $this->defaultFilters;
    }

    public function getDefaultOrders(): array
    {
        return $this->defaultOrders;
    }

    public function getRoleAccesses(): array
    {
        return $this->roleAccesses;
    }
}