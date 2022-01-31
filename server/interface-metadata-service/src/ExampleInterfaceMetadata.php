<?php


use App\Models\Post;
use Egal\Core\Interface\TableField;
use Egal\Core\Interface\TableMetadata;
use Egal\Core\Interface\TableRelation;
use Egal\Core\Model\Filter\CompositeFilter;
use Egal\Core\Model\Filter\Filter;

$metadata = TableMetadata::make(Post::getModelMetadata())
    ->setRoleAccesses(['admin'])
    ->setFields(
        TableField::make('title')
            ->setLabel('Заголовок')
            ->setComputed([
                'format:upper'
            ]),
        TableField::make('description')
            ->setLabel('Описание')
    )
    ->setRelations(
        TableRelation::make('channels')
    )
    ->setDefaultFilters(
        Filter::make('description', '!=', 'lalala'),
        CompositeFilter::make(
            Filter::make('description', '!=', 'lalala' , 'or'),
            Filter::make('description', '!=', 'lalala')
        )
    )
    ->setDefaultOrders();

return $metadata;