<?php

namespace App\Feed;

class Meta
{
    public function __construct($params)
    {
        foreach ($params as $key=>$param) {
            $this->$key = $param;
        }
    }
}
