<?php

namespace App\Requests;

trait RequestTrait
{
    public function __construct($request)
    {
        foreach ($request as $key => $value) {
            $this->{$key} = $value;
        }
    }
}
