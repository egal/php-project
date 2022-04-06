<?php

namespace Egal\Core\Rest\Filter;

class CompositeCondition
{
    protected Combiner $combiner;
    protected array $conditions = [];

    public function __construct(array $conditions = [], Combiner $combiner = Combiner::And)
    {
        $this->combiner = $combiner;
        $this->conditions = $conditions;
    }

    public function getCombiner(): Combiner
    {
        return $this->combiner;
    }

    public function addCondition(Condition|CompositeCondition $condition): void
    {
        $this->conditions[] = $condition;
    }

    public function getConditions(): array
    {
        return $this->conditions;
    }

}
