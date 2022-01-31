<?php

namespace Egal\Core\Model\Filter;

class CompositeFilter implements FilterInterface
{

    protected array $filters;

    public static function make(FilterInterface ...$filters): self
    {
        $compositeFilter = new self();
        $compositeFilter->filters = $filters;

        return $compositeFilter;
    }

    public function getFilters(): array
    {
        return $this->filters;
    }

}