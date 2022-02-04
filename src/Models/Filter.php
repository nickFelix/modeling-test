<?php

namespace App\Models;

use App\Models\Node;
use App\Models\ConcatedFields;

class Filter extends Node
{

    private $operations = [];

    use ConcatedFields;

    public function __construct(String $type, $transformObject)
    {
        parent::__construct($type, $transformObject);
        $this->operations = $this->transformObject['operations'];
        $this->joinOperator = $this->transformObject['joinOperator'];
    }

    public function generateQuery(array $fields = [], string $from = ''): string
    {
        return " SELECT {$this->getConcatedFields($fields)} FROM `{$from}` WHERE" . $this->getFilters() . " ";
    }

    private function getFilters()
    {
        return $this->getOperations($this->transformObject['variable_field_name']);
    }

    private function getOperations(string $variable_field_name)
    {
        $filter = "";
        foreach ($this->operations as $operation) {
            $filter .= " `$variable_field_name` {$operation['operator']} {$operation['value']} {$this->joinOperator}";
        }
        return rtrim($filter, $this->joinOperator);
    }
}
