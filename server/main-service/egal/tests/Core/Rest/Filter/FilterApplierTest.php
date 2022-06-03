<?php

namespace Egal\Tests\Core\Rest\Filter;

use Carbon\Carbon;
use Egal\Core\Database\Metadata\Field as FieldMetadata;
use Egal\Core\Database\Metadata\Model as ModelMetadata;
use Egal\Core\Database\Model;
use Egal\Core\Rest\Filter\Combiner;
use Egal\Core\Rest\Filter\FieldCondition;
use Egal\Core\Rest\Filter\Field;
use Egal\Core\Rest\Filter\MorphRelationField;
use Egal\Core\Rest\Filter\Operator;
use Egal\Core\Rest\Filter\Query as FilterQuery;
use Egal\Core\Rest\Filter\RelationField;
use Egal\Core\Rest\Filter\ScopeFunction;
use Egal\Tests\DatabaseSchema;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;
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
                    FieldCondition::make($fieldName, Operator::Equals, 'first prd'),
                ]),
                [1]
            ],
            [
                FilterQuery::make([
                    FieldCondition::make($fieldName, Operator::Equals, 'first prd'),
                    FieldCondition::make($fieldName, Operator::Equals, 'second prd', Combiner::Or)
                ]),
                [1, 2]
            ],
            [
                FilterQuery::make([
                    FieldCondition::make($fieldName, Operator::Equals, 'first prd'),
                    FieldCondition::make($fieldName, Operator::Equals, 'second prd')
                ]),
                []
            ],
            [
                FilterQuery::make([
                    FieldCondition::make($fieldCategoryId, Operator::Equals, null)
                ]),
                [1]
            ],
            [
                FilterQuery::make([
                    FieldCondition::make($fieldCategoryId, Operator::NotEquals, null),
                    FilterQuery::make([
                        FieldCondition::make($fieldName, Operator::Equals, 'first prd'),
                        FieldCondition::make($fieldName, Operator::Equals, 'second prd', Combiner::Or),
                    ], Combiner::And),
                ]),
                [2]
            ]
        ];
    }

    public function filterApplierDataProviderRelationField(): array
    {
        $fieldCategoryName = new RelationField('name', 'category');

        return [
            [
                FilterQuery::make([
                    FieldCondition::make($fieldCategoryName, Operator::Equals, 'first ctg'),
                ]),
                [2]
            ],
            [
                FilterQuery::make([
                    FieldCondition::make($fieldCategoryName, Operator::Equals, 'first ctg'),
                    FieldCondition::make($fieldCategoryName, Operator::Equals, 'second ctg', Combiner::Or)
                ]),
                [2]
            ],
            [
                FilterQuery::make([
                    FieldCondition::make($fieldCategoryName, Operator::Equals, 'first ctg'),
                    FieldCondition::make($fieldCategoryName, Operator::Equals, 'second ctg')
                ]),
                []
            ],
            [
                FilterQuery::make([
                    FieldCondition::make($fieldCategoryName, Operator::Equals, null)
                ]),
                []
            ]
        ];
    }

    public function filterApplierDataProviderMorphRelationField(): array
    {
        $fieldCategoryCommentContent = new MorphRelationField('content', 'commentable', [ModelFilterApplierTestCategory::class]);
        $fieldProductCommentContent = new MorphRelationField('content', 'commentable', [ModelFilterApplierTestProduct::class]);

        return [
            [
                FilterQuery::make([
                    FieldCondition::make($fieldCategoryCommentContent, Operator::StartWithOperator, 'comment'),
                ]),
                [1, 2]
            ],
            [
                FilterQuery::make([
                    FieldCondition::make($fieldProductCommentContent, Operator::StartWithOperator, 'comment')
                ]),
                [3]
            ],
            [
                FilterQuery::make([
                    FieldCondition::make($fieldProductCommentContent, Operator::StartWithOperator, 'comment'),
                    FieldCondition::make($fieldCategoryCommentContent, Operator::StartWithOperator, 'comment')
                ]),
                []
            ],
            [
                FilterQuery::make([
                    FieldCondition::make($fieldProductCommentContent, Operator::StartWithOperator, 'not')
                ]),
                []
            ]
        ];
    }

    public function filterApplierDataProviderScope(): array
    {

        return [
            [
                FilterQuery::make([
                    ScopeFunction::make('category', ['key' => 'categoryName', 'value' => 'first ctg']),
                ]),
                [2]
            ],
//            [
//                FilterQuery::make([
//                    FieldCondition::make($fieldProductCommentContent, Operator::StartWithOperator, 'comment')
//                ]),
//                [3]
//            ],
//            [
//                FilterQuery::make([
//                    FieldCondition::make($fieldProductCommentContent, Operator::StartWithOperator, 'comment'),
//                    FieldCondition::make($fieldCategoryCommentContent, Operator::StartWithOperator, 'comment')
//                ]),
//                []
//            ],
//            [
//                FilterQuery::make([
//                    FieldCondition::make($fieldProductCommentContent, Operator::StartWithOperator, 'not')
//                ]),
//                []
//            ]
        ];
    }

    /**
     * @dataProvider filterApplierDataProviderField()
     * @dataProvider filterApplierDataProviderRelationField()
     * @dataProvider filterApplierDataProviderScope()
     */
    public function testFilterApplier(FilterQuery $filterQuery, array|string $expected)
    {

        if (is_string($expected)) {
            $this->expectException($expected);
        }

        $result = array_column(ModelFilterApplierTestProduct::filter($filterQuery)->get()->toArray(), 'id');

        $this->assertEquals($expected, $result);

    }

    /**
     * @dataProvider filterApplierDataProviderMorphRelationField()
     */
    public function testFilterByMorphRelationApplier(FilterQuery $filterQuery, array|string $expected)
    {

        if (is_string($expected)) {
            $this->expectException($expected);
        }

        $result = array_column(ModelFilterApplierTestComment::filter($filterQuery)->get()->toArray(), 'id');

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
            $table->text('content');
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
            'content' => 'comment to 1 category'
        ]);
        ModelFilterApplierTestComment::query()->insert([
            'commentable_type' => ModelFilterApplierTestCategory::class,
            'commentable_id' => 2,
            'content' => 'comment to 2 category'
        ]);
        ModelFilterApplierTestComment::query()->insert([
            'commentable_type' => ModelFilterApplierTestProduct::class,
            'commentable_id' => 1,
            'content' => 'comment to 1 product'
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

    public function comments(): MorphMany
    {
        return $this->morphMany(ModelFilterApplierTestComment::class, 'commentable');
    }

    public function scopeCategory(\Illuminate\Database\Eloquent\Builder $query, string $categoryName)
    {
        return $query->whereHas('categories', function($query) use ($categoryName) {
            $query->where('name', '=', $categoryName);
        });
    }

    public function scopeTodayCreated(\Illuminate\Database\Eloquent\Builder $query)
    {
        return $query->where('created_at', Carbon::today());
    }
}

class ModelFilterApplierTestComment extends Model
{
    protected $table = 'comments';

    public function initializeMetadata(): ModelMetadata
    {
        return ModelMetadata::make(static::class)
            ->fields(
                FieldMetadata::make('content')
                    ->required()
                    ->fillable(),
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
