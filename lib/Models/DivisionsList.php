<?php

namespace IndicoPlus\CaritasApp\Models;

use IndicoPlus\CaritasApp\Models\DivisionListItem;

class DivisionsList
{
    public $divisions = [];

    public function __construct($json = null)
    {
        if (empty($json) || !is_array($json)) {
            return;
        }

        $this->divisions = array_map(function ($item) {
            return new DivisionListItem($item);
        }, $json);
    }
}
