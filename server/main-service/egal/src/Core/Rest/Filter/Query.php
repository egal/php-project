<?php

namespace Egal\Core\Rest\Filter;

class Query
{
    private array $content = [];

    /**
     * @param array $content
     */
    public function __construct(array $content = [])
    {
        $this->content = $content;
    }

    public function getContent(): array
    {
        return $this->content;
    }

    public function addContentItem($item): void
    {
        $this->content[] = $item;
    }
}
