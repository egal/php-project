<?php


use Egal\Core\Interface\TableField;
use Egal\Core\Interface\TableMetadata;
use Egal\Core\Interface\TableRelation;
use Egal\Core\Model\Filter\CompositeFilter;
use Egal\Core\Model\Filter\Filter;

$postMetadata = \App\Models\Post::getModelMetadata();
$metadata = TableMetadata::make($postMetadata)
    ->setRoleAccesses(['admin'])
    ->setFields(
        TableField::make('title')
            ->setLabel()
            ->setComputed(),
        TableField::make('description')
            ->setLabel()
    )
    ->setRelations(TableRelation::make()->setName('channels'))
//    ->applyHiddenFilters(
//        TableFilter::make()
//            ->setParam(TableFilter::make()
//                ->setParam('title')
//                ->setOperator('=')
//                ->setValue('test'))
//            ->setOperator('and')
//            ->setValue()
//
//    )
    ->setRequestFilters(
        CompositeFilter::make()
            ->setParam(
                Filter::make()
                    ->setParam('title')
                    ->setOperator('!=')
                    ->setValue('test')
            )
            ->setOperator('AND')
            ->setDefaulHiddenFilter(
                Filter::make('description', '!=', 'lalala' , 'and'),
                CompositeFilter::make(
                    Filter::make('description', '!=', 'lalala' , 'and'),
                    Filter::make('description', '!=', 'lalala' , 'and')
                )
            )
            ->setOperatorAfter('OR'),
    )
    ->setRequestOrders();

return $metadata;