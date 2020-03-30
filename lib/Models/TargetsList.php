<?php

namespace IndicoPlus\CaritasApp\Models;

use IndicoPlus\CaritasApp\Models\TargetListItem;

class TargetsList
{
    public $targets = [];
    public $is_active = false;
    public $name = null;

    public function __construct($json = null)
    {
        if (empty($json) || !is_object($json)) {
            return;
        }

        $this->is_active = empty($json->is_active) ? false : $json->is_active;
        $this->name = empty($json->name) ? null : $json->name;

        if (!empty($json->targets) && is_array($json->targets)) {
            $this->targets = array_map(function ($item) {
                return new TargetListItem($item);
            }, $json->targets);
        }
    }
}
