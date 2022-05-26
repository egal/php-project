<?php

namespace Egal\Core\Database;

use Egal\Core\Database\Metadata\Model as ModelMetadata;
use Egal\Core\Rest\Filter\FilterApplier;
use Egal\Core\Rest\Filter\Query as FilterQuery;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model as BaseModel;

/**
 * #TODO: Реализовать EnumModel.
 */
abstract class Model extends BaseModel
{

    private ModelMetadata $metadata;

    abstract public function initializeMetadata(): ModelMetadata;

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        # TODO: Cache remember.
        $this->metadata = $this->initializeMetadata();

        $this->syncMetadata();
    }

    public function getMetadata(): ModelMetadata
    {
        return $this->metadata;
    }

    # TODO: May be need change method name.
    private function syncMetadata(): void
    {
        $metadata = $this->getMetadata();
        $this->mergeFillable($metadata->getFillableFieldsNames());
    }

    public function scopeFilter(Builder $query, FilterQuery $filterQuery): Builder
    {
//        FilterApplier::validateQuery($this->getMetadata(), $filterQuery);

        return FilterApplier::applyQuery($query, $filterQuery);
    }

}
