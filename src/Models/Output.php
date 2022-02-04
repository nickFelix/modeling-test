<?php

namespace App\Models;

use App\Models\Node;

class Output extends Node
{

    public function __construct(String $type, $transformObject)
    {
        parent::__construct($type, $transformObject);
    }

    public function generateQuery(array $fields = [], string $from = ''): string
    {
        return " SELECT * FROM `{$from}` {$this->formatLimit()}";
    }

    private function formatLimit()
    {
        $limitStr = '';
        $limitKeys = array_keys($this->transformObject);
        foreach ($limitKeys as $key) {
            $limitStr .= "{$key} {$this->transformObject[$key]} ";
        }

        return $limitStr;
    }
}
