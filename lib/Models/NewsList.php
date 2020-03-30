<?php

namespace IndicoPlus\CaritasApp\Models;

use IndicoPlus\CaritasApp\Models\NewsListItem;

class NewsList
{
    public $current_page = 1;
    public $data = [];
    public $first_page_url = null;
    public $last_page_url = null;
    public $next_page_url = null;
    public $last_page = null;
    public $per_page = null;

    public function __construct($json = null)
    {
        if (empty($json) || !is_object($json)) {
            return;
        }

        $this->current_page = empty($json->current_page) ? 1 : $json->current_page;
        $this->first_page_url = empty($json->first_page_url) ? null : $json->first_page_url;
        $this->last_page_url = empty($json->last_page_url) ? null : $json->last_page_url;
        $this->next_page_url = empty($json->next_page_url) ? null : $json->next_page_url;
        $this->last_page = empty($json->last_page) ? null : $json->last_page;
        $this->per_page = empty($json->per_page) ? null : $json->per_page;

        if (!empty($json->data) && is_array($json->data)) {
            $this->data = array_map(function ($item) {
                return new NewsListItem($item);
            }, $json->data);
        }
    }
}
