<?php

namespace App\Models;

abstract class Node
{
    protected string $type;
    protected $transformObject;

    public function __construct(String $type, $transformObject)
    {
        $this->type = $type;
        $this->transformObject = $transformObject;
    }

    abstract public function generateQuery(array $fields = [], string $from = ''): string;
    public function getType(): string
    {
        return $this->type;
    }

    public function getTransformObject()
    {
        return $this->transformObject;
    }
}
