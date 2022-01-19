<?php

namespace App\egal;

abstract class EgalInterfaceMetadata
{
    protected string $model;
    protected array $fields;
    protected array $relations;
    protected array $filters;
    protected array $orders;

    public function __construct()
    {
        $this->setModel();
        $this->setFields();
        $this->setRelations();
        $this->setFilters();
        $this->setOrders();
    }

    abstract public function setModel();

    abstract public function setFields();

    public function setRelations()
    {
        $this->relations = [];
    }

    public function setFilters()
    {
        $this->filters = [];
    }

    public function setOrders()
    {
        $this->orders = [];
    }

    public function toJson()
    {

    }
}
