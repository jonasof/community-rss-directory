<?php

namespace App\Utils;

class FeedMeta
{
    public function __construct($params)
    {
        foreach ($params as $key=>$param) {
            $this->$key = $param;
        }
    }
}
