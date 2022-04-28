<?php

namespace Egal\Tests\Core\Rest\Filter;

use Egal\Core\Database\Metadata\Field as FieldMetadata;
use Egal\Core\Database\Metadata\Model as ModelMetadata;
use Egal\Core\Database\Model;
use Egal\Core\Rest\Filter\Combiner;
use Egal\Core\Rest\Filter\Condition;
use Egal\Core\Rest\Filter\Field;
use Egal\Core\Rest\Filter\Operator;
use Egal\Core\Rest\Filter\Query as FilterQuery;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use PHPUnit\Framework\TestCase;

class FilterApplierTest extends TestCase
{
    public function filterApplierDataProvider(): array
    {
        $field = new Field('name');
        $field->setRelation('category');

        return [
            [
                FilterQuery::make([
                    Condition::make('field', Operator::Equals, null, Combiner::And),
                ])
            ]
        ];
    }

    /**
     * @dataProvider filterApplierDataProvider()
     */
    public function testFilterApplier(FilterQuery $filterQuery, string $expectedSql = '')
    {
        dump(ModelTestProduct::filter($filterQuery)->toSql());
    }
}

class ModelTestCategory extends Model
{

    public function initializeMetadata(): ModelMetadata
    {
        return ModelMetadata::make(static::class)
            ->fields(
                FieldMetadata::make('name')
                    ->required()
                    ->fillable()
            );
    }
}

class ModelTestProduct extends Model
{

    public function initializeMetadata(): ModelMetadata
    {
        return ModelMetadata::make(static::class)
            ->fields(
                FieldMetadata::make('name')
                    ->required()
                    ->fillable(),
                FieldMetadata::make('category_id')
                    ->required()
                    ->fillable()
            );
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(ModelTestCategory::class);
    }
}
