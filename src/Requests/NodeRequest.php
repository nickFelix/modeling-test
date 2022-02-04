<?php

namespace App\Requests;

use App\Requests\RequestTrait;

class NodeRequest
{
    public String $type;
    public array $transformObject;

    use RequestTrait {
        RequestTrait::__construct as private __tConstruct;
    }

    public function __construct($request)
    {
        $this->__tConstruct($request);
    }
}
