<?php

class QueryParamsDTO
{
    public ?int $limit;
    public ?int $page;
    public ?string $name;

    public function __construct($limit, $page, $name)
    {
        $this->limit = $limit;
        $this->page = $page;
        $this->name = $name;
    }
}
