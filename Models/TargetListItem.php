<?php

namespace CaritasApp\Models;

use CaritasApp\Models\Photo;

class TargetListItem
{
    public $id = null;
    public $photo = null;
    public $summary = null;
    public $name = null;
    public $division = null;
    public $target_amount = 0;
    public $collected_amount = 0;

    public function __construct($json = null)
    {
        if (empty($json) || !is_object($json)) {
            return;
        }

        $this->id = empty($json->id) ? null : $json->id;
        $this->photo = empty($json->photo) ? null : new Photo($json->photo);
        $this->summary = empty($json->summary) ? null : $json->summary;
        $this->name = empty($json->name) ? null : $json->name;
        $this->division = empty($json->division) ? null : $json->division;
        $this->target_amount = empty($json->target_amount) ? 0 : intval($json->target_amount);
        $this->collected_amount = empty($json->collected_amount) ? 0 : intval($json->collected_amount);
    }
}
