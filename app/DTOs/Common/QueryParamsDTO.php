<?php

class QueryParamsDTO
{
    public ?int $limit;
    public ?int $page;
    public ?string $name;

    public function __construct($limit = 2, $page = 1, $name = null)
    {
        $this->limit = $limit;
        $this->page = $page;
        $this->name = $name;
    }
}
