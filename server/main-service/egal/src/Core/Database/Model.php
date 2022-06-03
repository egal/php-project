<?php

namespace Egal\Core\Database;

use Egal\Core\Database\Metadata\Model as ModelMetadata;
use Egal\Core\Rest\Filter\Applier as FilterApplier;
use Egal\Core\Rest\Filter\Query as FilterQuery;
use Egal\Core\Rest\Select\Applier as SelectApplier;
use Egal\Core\Rest\Scope\Applier as ScopeApplier;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model as BaseModel;
use Illuminate\Support\Facades\Log;

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

    //TODO пользователь может переопределить, нужно что-то придумать
    public function scopeRestFilters(Builder $query, FilterQuery $filterQuery): Builder
    {
//        FilterApplier::validateQuery($this->getMetadata(), $filterQuery);

        return FilterApplier::applyQuery($query, $filterQuery);
    }

    public function scopeRestSelects(Builder $query, array $fields): Builder
    {
        Log::debug('scopeApplySelects');
        return SelectApplier::apply($query, $fields);
    }

    public function scopeRestScopes(Builder $query, array $scopes): Builder
    {
        Log::debug('scopeApplyScopes', $scopes);
        return ScopeApplier::apply($query, $scopes);
    }

}
