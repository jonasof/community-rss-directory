<?php

namespace App\Utils;

class FeedMeta
{
    public $title;
    public $description;
    public $icon_url;

    public function __construct($params)
    {
        foreach ($params as $key=>$param) {
            $this->$key = $param;
        }
    }
}
