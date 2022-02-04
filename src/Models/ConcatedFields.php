<?php

namespace App\Models;

trait ConcatedFields
{
    private function getConcatedFields($fields)
    {
        return "`" . implode("`,`", $fields) . "`";
    }
}
