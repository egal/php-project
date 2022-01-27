<?php

use Egal\Core\TableField;
use Egal\Core\TableFilter;
use Egal\Core\TableMetadata;


$metadata = TableMetadata::make()
    ->addRoleAccesses()
    ->addFields(
        TableField::make()
            ->setLabel()
            ->setType()
            ->setComputed(),
        TableField::make()
            ->setLabel()
            ->setType()
    )
    ->addField(

    )
    ->addRelation()
    ->applyHiddenFilters(
        TableFilter::make()
            ->setParam(TableFilter::make()
                ->setParam('title')
                ->setOperator('=')
                ->setValue('test'))
            ->setOperator('and')
            ->setValue()

    )
    ->addOrders();

return $metadata;