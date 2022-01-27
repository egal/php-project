<?php

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
    ->addFilters()
    ->addOrders();

return $metadata;