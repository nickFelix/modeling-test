<?php

namespace App\Models;

use App\Models\Node;
use App\Models\ConcatedFields;

class Sort extends Node
{

    const ASC = 'ASC';
    const DESC = 'DESC';

    private $sortedMap = [];

    use ConcatedFields;

    public function __construct(String $type, $transformObject)
    {
        parent::__construct($type, $transformObject);
        $this->sortedMap = $this->mapAscDescSort();
    }

    private function mapAscDescSort()
    {
        $map = [
            self::ASC => [],
            self::DESC => []
        ];

        $sortOperations = $this->transformObject;
        foreach ($sortOperations as $key => $sort) {
            array_push($map[$sort['order']], $sort['target']);
        }

        return $map;
    }

    public function generateQuery(array $fields = [], string $from = ''): string
    {
        return " SELECT {$this->getConcatedFields($fields)} FROM `{$from}` ORDER BY " . $this->getSort() . " ";
    }

    private function getSort()
    {
        $ascSort = $this->getSortElements(self::ASC);
        $descSort = $this->getSortElements(self::DESC);

        return $this->formatResult($ascSort, $descSort);
    }

    private function getSortElements($sortString = '')
    {
        $elements = '';
        foreach ($this->sortedMap[$sortString] as $key => $ascSort) {
            $elements .= "`{$ascSort}`, ";
        }

        if (strlen($elements) === 0) {
            return $elements;
        }

        return rtrim($elements, ", ") . ' ' . $sortString;
    }

    private function formatResult(string $ascSort, string $descSort)
    {
        if (strlen($ascSort) == 0) {
            return $descSort;
        } else if (strlen($descSort) == 0) {
            return $ascSort;
        }

        return $ascSort . ', ' . $descSort;
    }
}
