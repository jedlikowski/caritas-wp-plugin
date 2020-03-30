<?php

namespace IndicoPlus\CaritasApp\Models;

use IndicoPlus\CaritasApp\Models\Date;
use IndicoPlus\CaritasApp\Models\Photo;

class NewsListItem
{
    public $id = null;
    public $photo = null;
    public $title = null;
    public $created_at = null;

    public function __construct($json = null)
    {
        if (empty($json) || !is_object($json)) {
            return;
        }

        $this->id = empty($json->id) ? null : $json->id;
        $this->photo = empty($json->photo) ? null : new Photo($json->photo);
        $this->title = empty($json->title) ? null : $json->title;

        if (!empty($json->created_at)) {
            $this->created_at = new Date($json->created_at);
        } else {
            $this->created_at = new Date(date('c'));
        }
    }
}
