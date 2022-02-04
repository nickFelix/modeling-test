<?php

namespace App\Models;

use App\Models\Node;
use App\Models\ConcatedFields;

class Input extends Node
{

    private array $fields = [];

    use ConcatedFields;

    public function __construct(String $type, $transformObject)
    {
        parent::__construct($type, $transformObject);
        $this->fields = $this->transformObject['fields'];
    }

    public function generateQuery(array $fields = [], string $from = ''): string
    {
        return " SELECT " . $this->getConcatedFields($this->fields) . " FROM `{$this->transformObject['tableName']}` ";
    }

    public function getFields()
    {
        return $this->fields;
    }
}
