<?php

namespace CaritasApp\Core;

use CaritasApp\Core\Router;

class Plugin
{
    public $plugin_path;

    public function __construct($plugin_path)
    {
        $this->plugin_path = $plugin_path;
        new Router();
    }
}
