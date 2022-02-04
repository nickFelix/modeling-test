<?php

namespace App\Services;

use App\Requests\EdgeRequest;
use App\Factories\NodeFactory;
use App\Helpers\QueryBuilderHelper;
use App\Services\QueryBuilder;
use App\Services\NodeMapper;

class Parser
{

    private $requestData;
    private array $requestNodes = [];
    private array $nodes = [];

    private QueryBuilder $queryBuilder;
    private QueryBuilderHelper $queryBuilderHelper;
    private NodeMapper $nodeMapper;

    public function __construct(QueryBuilder $queryBuilder, QueryBuilderHelper $queryBuilderHelper, NodeMapper $nodeMapper)
    {
        $this->queryBuilder = $queryBuilder;
        $this->queryBuilderHelper = $queryBuilderHelper;
        $this->nodeMapper = $nodeMapper;
        $this->requestData = json_decode($this->LoadData(), true);
        $this->mapNodesToKeys();
    }

    private function LoadData()
    {
        return file_get_contents(getcwd() . "/src/resources/request-data.json");
    }

    private function mapNodesToKeys()
    {
        $nodes = $this->requestData['nodes'];
        $this->nodeMapper->setNodes($nodes);
        $this->requestNodes = $this->nodeMapper->mapNodesToKeys();
    }

    public function run()
    {
        $edges = $this->requestData['edges'];
        foreach ($edges as $index => $edge) {
            $this->processEdge($edge, $index);
        }

        $lastFrom = $edges[sizeof($edges) - 1]['to'];
        var_dump($this->queryBuilder->getFinalResult($lastFrom));
    }

    private function processEdge(array $edge, int $index)
    {
        $edge = new EdgeRequest($edge);
        $lastEdge = sizeof($this->requestData['edges']) - 1;

        $this->initializeNodes($edge);

        if ($index === $lastEdge) {
            return $this->generateLastSubqueries($edge);
        }

        return $this->generateSubquery($edge, 'from');
    }

    private function initializeNodes(EdgeRequest $edge)
    {
        if (!array_key_exists($edge->from, $this->nodes)) {
            $this->nodes[$edge->from] = $this->getNodeInstance($edge, 'from');
        }

        if (!array_key_exists($edge->to, $this->nodes)) {
            $this->nodes[$edge->to] = $this->getNodeInstance($edge, 'to');
        }
    }

    private function getNodeInstance(EdgeRequest $edge, $key)
    {
        $nodeRequestData = $this->requestNodes[$edge->{$key}];
        return NodeFactory::makeNode($nodeRequestData);
    }

    private function generateLastSubqueries(EdgeRequest $edge)
    {
        $this->generateSubquery($edge, 'from');
        return $this->generateSubquery($edge, 'to');
    }

    private function generateSubquery(EdgeRequest $edge, string $key)
    {
        $subquery = $this->getSubquery($edge, $key);
        $lastAlias = $this->queryBuilder->concatQuery($subquery, $edge->{$key});
        $this->queryBuilderHelper->setLastAlias($lastAlias);
        return $lastAlias;
    }

    private function getSubquery(EdgeRequest $edge, $key)
    {
        return $this->nodes[$edge->{$key}]->generateQuery(
            $this->nodeMapper->getFieldsFromInputNode($this->nodes),
            $this->queryBuilderHelper->getLastAlias()
        );
    }
}
