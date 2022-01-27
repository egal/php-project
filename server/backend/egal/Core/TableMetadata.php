<?php

namespace Egal\Core;

class TableMetadata
{

    protected ModelMetadata $modelMetadata;

    public static function make(ModelMetadata $modelMetadata): self
    {
    }

    public function addFields(TableField $field):self
    {
    }

    public function addRelations(TableRelation $relation):self
    {
    }

    public function addFilters():self
    {
    }

    public function addOrders(TableOrder $orders):self
    {
    }

    public function addRoleAccesses(array $roles):self
    {
    }
}