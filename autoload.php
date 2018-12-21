<?php

$plugin_path = plugin_dir_path(__FILE__);
$foldersToAutoload = ['Core', 'Controllers', 'Models'];

foreach ($foldersToAutoload as $folder) {
    foreach (glob($plugin_path . $folder . "/*.php") as $filename) {
        require_once $filename;
    }
}

require_once $plugin_path . 'vendor/jedlikowski/WP_Router/Router.php';
