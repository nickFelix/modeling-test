<?php

namespace App\Requests;

use App\Requests\RequestTrait;

class EdgeRequest
{
    public String $from;
    public String $to;

    use RequestTrait {
        RequestTrait::__construct as private __tConstruct;
    }

    public function __construct($request)
    {
        $this->__tConstruct($request);
    }
}
