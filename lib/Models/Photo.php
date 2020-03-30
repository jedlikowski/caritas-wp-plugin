<?php

namespace IndicoPlus\CaritasApp\Models;

class Photo
{
    public $url = null;

    public function __construct($json)
    {
        if (empty($json) || !is_object($json)) {
            return;
        }

        if (empty($json->url) || !is_string($json->url)) {
            return;
        }

        $this->url = $json->url;
    }
}
