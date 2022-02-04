<?php

namespace App\Factories;

use App\Requests\NodeRequest;
use App\Models\Node;
use App\Models\Input;
use App\Models\Filter;
use App\Models\Sort;
use App\Models\TextTransformation;
use App\Models\Output;

class NodeFactory
{

    const INPUT = 'INPUT';
    const FILTER = 'FILTER';
    const SORT = 'SORT';
    const TEXT_TRANSFORMATION = 'TEXT_TRANSFORMATION';
    const OUTPUT = 'OUTPUT';

    public static function makeNode(NodeRequest $nodeRequest): Node
    {
        switch ($nodeRequest->type) {
            case self::INPUT:
                return new Input($nodeRequest->type, $nodeRequest->transformObject);
                break;
            case self::FILTER:
                return new Filter($nodeRequest->type, $nodeRequest->transformObject);
                break;
            case self::SORT:
                return new Sort($nodeRequest->type, $nodeRequest->transformObject);
                break;
            case self::TEXT_TRANSFORMATION:
                return new TextTransformation($nodeRequest->type, $nodeRequest->transformObject);
                break;
            case self::OUTPUT:
                return new Output($nodeRequest->type, $nodeRequest->transformObject);
                break;
            default:
                throw new \Exception("Invalid node type {$nodeRequest->type}", 1);
                break;
        }
    }
}
