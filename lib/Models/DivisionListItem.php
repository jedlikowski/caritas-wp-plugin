<?php

namespace IndicoPlus\CaritasApp\Models;

class DivisionListItem
{
    public $id = null;
    public $name = null;
    public $is_active = false;
    public $distance = 0;

    public function __construct($json = null)
    {
        if (empty($json) || !is_object($json)) {
            return;
        }

        $this->id = empty($json->id) ? null : $json->id;
        $this->name = empty($json->name) ? null : $json->name;
        $this->is_active = empty($json->is_active) ? 0 : $json->is_active;
        $this->distance = empty($json->distance) ? 0 : $json->distance;
    }
}
