<?php

namespace App\Models;

use App\Models\Node;
use App\Models\ConcatedFields;

class TextTransformation extends Node
{

    use ConcatedFields;

    public function __construct(String $type, $transformObject)
    {
        parent::__construct($type, $transformObject);
    }

    public function generateQuery(array $fields = [], string $from = ''): string
    {
        return " SELECT {$this->formatFields($fields)} FROM `{$from}` ";
    }

    private function formatFields(array $fields = [])
    {
        $queryFields = $this->getConcatedFields($fields);
        $transformOperations = $this->transformObject;
        foreach ($transformOperations as $operation) {
            $queryFields = str_replace(
                "`{$operation['column']}`",
                " {$operation['transformation']} (`{$operation['column']}`) AS `{$operation['column']}`",
                $queryFields
            );
        }

        return $queryFields;
    }
}
