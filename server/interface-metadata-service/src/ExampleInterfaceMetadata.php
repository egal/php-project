<?php

use App\egal\TableField;
use App\egal\TableMetadata;

$metadata = new TableMetadata();

$metadata
    ->addField(
        TableField::make()
            ->setLabel()
            ->setType()
            ->setComputed()
    )
    ->addField(
        TableField::make()
            ->setLabel()
            ->setType()
    )
    ->addRelation()
    ->addFilters()
    ->addOrders();

return $metadata;