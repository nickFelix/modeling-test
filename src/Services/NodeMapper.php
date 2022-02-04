<?php

namespace App\Services;

use App\Requests\NodeRequest;

class NodeMapper
{

    private $nodes = [];
    private $fields = null;

    const INPUT = 'INPUT';

    public function __construct(array $nodes = [])
    {
        $this->nodes = $nodes;
    }

    public function setNodes(array $nodes = [])
    {
        $this->nodes = $nodes;
    }

    public function mapNodesToKeys()
    {
        foreach ($this->nodes as $node) {
            $mappedNodes[$node['key']] = new NodeRequest($node);
        }

        return $mappedNodes;
    }

    public function getFieldsFromInputNode(array $nodes = [])
    {
        if (!is_null($this->fields)) {
            return $this->fields;
        }
        return $this->findFields($nodes);
    }

    private function findFields(array $nodes = [])
    {
        foreach ($nodes as $node) {
            if ($node->getType() == self::INPUT && $this->nodeHasFields($node)) {
                $this->fields = $node->getFields();
                return $this->fields;
            }
        }

        throw new \Exception("'Fields' key was not found in node type " . self::INPUT, 1);
    }

    private function nodeHasFields($node): bool
    {
        return !empty($node->getFields());
    }
}
