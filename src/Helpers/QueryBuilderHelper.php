<?php

namespace App\Helpers;

class QueryBuilderHelper
{

    private string $lastAlias = '';

    public function setLastAlias($lastAlias): void
    {
        $this->lastAlias = $lastAlias;
    }

    public function getLastAlias(): string
    {
        return $this->lastAlias;
    }
}
