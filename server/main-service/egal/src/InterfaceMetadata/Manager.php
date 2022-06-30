<?php

namespace Egal\InterfaceMetadata;

class Manager
{
    private array $components = [];

    public function component(ComponentMetadata $component): self
    {
        $this->components[] = $component;

        return $this;
    }

    public function getComponents(): array
    {
        return $this->components;
    }
}
