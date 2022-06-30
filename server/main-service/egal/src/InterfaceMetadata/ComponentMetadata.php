<?php

namespace Egal\InterfaceMetadata;

class ComponentMetadata
{
    private string $name;

    private array $widgets = [];

    public static function make(string $name): self
    {
        $page = new self();
        $page->setName($name);

        return $page;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function widgets(WidgetMetadata ...$widgets): self
    {
        $this->widgets = array_merge($this->widgets, $widgets);

        return $this;
    }

    private function getWidgetsArray(): array
    {
        $widgetsArray = [];
        foreach ($this->widgets as $widget) {
            $widgetsArray[] = $widget->toArray();
        }

        return $widgetsArray;
    }

    public function toArray(): array
    {
        return [
            'name' => $this->name,
            'widgets' => $this->getWidgetsArray()
        ];
    }
}
