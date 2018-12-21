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
    }
}
