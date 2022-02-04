<?php

namespace App\Services;

class QueryBuilder
{

    private string $concatedQuery;

    public function __construct()
    {
        $this->concatedQuery = "WITH ";
    }

    public function setFields(String $fields = ''): void
    {
        $this->fields = $fields;
    }

    public function concatQuery($subquery, $alias): string
    {
        $this->concatedQuery .= "{$alias} AS ({$subquery}), ";
        return $alias;
    }

    public function getFinalResult($subquery): string
    {
        $this->removeLastComma();
        return $this->concatedQuery . " SELECT * FROM {$subquery}; ";
    }

    private function removeLastComma()
    {
        $this->concatedQuery = rtrim($this->concatedQuery, ', ');
    }
}
