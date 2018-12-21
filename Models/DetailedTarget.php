<?php

namespace CaritasApp\Models;

use CaritasApp\Models\Photo;

class DetailedTarget
{
    public $id = null;
    public $price = 0;
    public $name = '';
    public $photo = null;

    public function __construct($json = null)
    {
        if (empty($json) || !is_object($json)) {
            return;
        }

        $this->id = empty($json->id) ? '' : $json->id;
        $this->name = empty($json->name) ? '' : $json->name;
        $this->price = empty($json->price) ? 0 : intval($json->price);
        $this->photo = empty($json->photo) ? null : new Photo($json->photo);
    }
}
