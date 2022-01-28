<?php

namespace Egal\Core\Route;

class ResourcesCacheStore
{
    /** @var RegisteredResource[] */
    protected $resources;

    public function addResource(RegisteredResource $resource): self
    {
        $this->resources[] = $resource;

        return $this;
    }

    public function getResources(): array
    {
        return $this->resources;
    }
}
