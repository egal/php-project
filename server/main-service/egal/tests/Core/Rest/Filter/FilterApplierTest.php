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
use Egal\Core\Rest\Filter\RelationField;
use Egal\Tests\DatabaseSchema;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Schema\Blueprint;
use PHPUnit\Framework\TestCase;

class FilterApplierTest extends TestCase
{
    use DatabaseSchema;

    public function filterApplierDataProviderField(): array
    {
        $fieldName = new Field('name');
        $fieldCategoryId = new Field('category_id');

        return [
            [
                FilterQuery::make([
                    Condition::make($fieldName, Operator::Equals, 'first prd'),
                ]),
                [1]
            ],
//            [
//                FilterQuery::make([
//                    Condition::make($fieldName, Operator::Equals, 'first prd'),
//                    Condition::make($fieldName, Operator::Equals, 'second prd', Combiner::Or)
//                ]),
//                [1, 2]
//            ],
//            [
//                FilterQuery::make([
//                    Condition::make($fieldName, Operator::Equals, 'first prd'),
//                    Condition::make($fieldName, Operator::Equals, 'second prd')
//                ]),
//                []
//            ],
//            [
//                FilterQuery::make([
//                    Condition::make($fieldCategoryId, Operator::Equals, null)
//                ]),
//                [1]
//            ],
//            [
//                FilterQuery::make([
//                    Condition::make($fieldCategoryId, Operator::NotEquals, null),
//                    FilterQuery::make([
//                        Condition::make($fieldName, Operator::Equals, 'first prd'),
//                        Condition::make($fieldName, Operator::Equals, 'second prd', Combiner::Or),
//                    ], Combiner::And),
//                ]),
//                [2]
//            ]
        ];
    }

    public function filterApplierDataProviderRelationField(): array
    {
        $fieldCategoryName = new RelationField('name', 'category');

        return [
            [
                FilterQuery::make([
                    Condition::make($fieldCategoryName, Operator::Equals, 'first ctg'),
                ]),
                [2]
            ],
            [
                FilterQuery::make([
                    Condition::make($fieldCategoryName, Operator::Equals, 'first ctg'),
                    Condition::make($fieldCategoryName, Operator::Equals, 'second ctg', Combiner::Or)
                ]),
                [2]
            ],
            [
                FilterQuery::make([
                    Condition::make($fieldCategoryName, Operator::Equals, 'first ctg'),
                    Condition::make($fieldCategoryName, Operator::Equals, 'second ctg')
                ]),
                []
            ],
            [
                FilterQuery::make([
                    Condition::make($fieldCategoryName, Operator::Equals, null)
                ]),
                []
            ]
        ];
    }

    public function filterApplierDataProviderMorphRelationField(): array
    {
        $fieldCategoryName = new RelationField('name', 'category');

        return [
            [
                FilterQuery::make([
                    Condition::make($fieldCategoryName, Operator::Equals, 'first ctg'),
                ]),
                [2]
            ],
            [
                FilterQuery::make([
                    Condition::make($fieldCategoryName, Operator::Equals, 'first ctg'),
                    Condition::make($fieldCategoryName, Operator::Equals, 'second ctg', Combiner::Or)
                ]),
                [2]
            ],
            [
                FilterQuery::make([
                    Condition::make($fieldCategoryName, Operator::Equals, 'first ctg'),
                    Condition::make($fieldCategoryName, Operator::Equals, 'second ctg')
                ]),
                []
            ],
            [
                FilterQuery::make([
                    Condition::make($fieldCategoryName, Operator::Equals, null)
                ]),
                []
            ]
        ];
    }

    /**
     * @dataProvider filterApplierDataProviderField()
//     * @dataProvider filterApplierDataProviderRelationField()
//     * @dataProvider filterApplierDataProviderMorphRelationField()
     */
    public function testFilterApplier(FilterQuery $filterQuery, array|string $expected)
    {

        if (is_string($expected)) {
            $this->expectException($expected);
        }

        $result = array_column(ModelFilterApplierTestProduct::filter($filterQuery)->get()->toArray(), 'id');

        $this->assertEquals($expected, $result);

    }

    protected function createSchema(): void
    {

        $this->schema()->create('categories', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->timestamps();
        });

        $this->schema()->create('products', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->unsignedBigInteger('category_id')->nullable();
            $table->foreign('category_id')->on('categories')->references('id');

            $table->timestamps();
        });

        $this->schema()->create('comments', function (Blueprint $table) {
            $table->increments('id');
            $table->morphs('commentable');
            $table->timestamps();
        });

        ModelFilterApplierTestCategory::query()->insert(['name' => 'first ctg']);
        ModelFilterApplierTestCategory::query()->insert(['name' => 'second ctg']);

        ModelFilterApplierTestProduct::query()->insert(['name' => 'first prd']);
        ModelFilterApplierTestProduct::query()->insert(['name' => 'second prd', 'category_id' => 1]);

        ModelFilterApplierTestComment::query()->insert([
            'commentable_type' => ModelFilterApplierTestCategory::class,
            'commentable_id' => 1,
        ]);
        ModelFilterApplierTestComment::query()->insert([
            'commentable_type' => ModelFilterApplierTestCategory::class,
            'commentable_id' => 2,
        ]);
        ModelFilterApplierTestComment::query()->insert([
            'commentable_type' => ModelFilterApplierTestProduct::class,
            'commentable_id' => 1,
        ]);
    }

    protected function dropSchema(): void
    {
        $this->schema()->drop('comments');
        $this->schema()->drop('products');
        $this->schema()->drop('categories');
    }
}

class ModelFilterApplierTestCategory extends Model
{
    protected $table = 'categories';

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

class ModelFilterApplierTestProduct extends Model
{
    protected $table = 'products';

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
        return $this->belongsTo(ModelFilterApplierTestCategory::class);
    }
}

class ModelFilterApplierTestComment extends Model
{
    protected $table = 'comments';

    public function initializeMetadata(): ModelMetadata
    {
        return ModelMetadata::make(static::class)
            ->fields(
                FieldMetadata::make('commentable_type')
                    ->required()
                    ->fillable(),
                FieldMetadata::make('commentable_id')
                    ->required()
                    ->fillable()
            );
    }

    public function commentable(): MorphTo
    {
        return $this->morphTo();
    }
}
