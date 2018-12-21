<?php

namespace CaritasApp\Models;

use CaritasApp\Models\Date;
use CaritasApp\Models\Photo;

class News
{
    public $title = '';
    public $content = '';
    public $created_at = null;
    public $gallery = [];

    public function __construct($json = null)
    {
        if (empty($json) || !is_object($json)) {
            return;
        }

        $this->title = empty($json->title) ? '' : $json->title;
        $this->content = empty($json->content) ? '' : $json->content;

        if (!empty($json->created_at)) {
            $this->created_at = new Date($json->created_at);
        } else {
            $this->created_at = new Date(date('c'));
        }

        if (!empty($json->gallery) && is_array($json->gallery)) {
            $this->gallery = array_map(function ($item) {
                return new Photo($item);
            }, $json->gallery);
        }
    }
}
