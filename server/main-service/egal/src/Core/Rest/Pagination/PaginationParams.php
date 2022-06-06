<?php

namespace Egal\Core\Rest\Pagination;

class PaginationParams
{
    private ?int $perPage = null;
    private ?int $page = null;

    public static function make(int $perPage = null, int $page = null): static
    {
        $paginationParams = new static();
        $paginationParams->perPage = $perPage;
        $paginationParams->page = $page;

        return $paginationParams;
    }

    public function getPerPage(): ?int
    {
        return $this->perPage;
    }

    public function getPage(): ?int
    {
        return $this->page;
    }

}
