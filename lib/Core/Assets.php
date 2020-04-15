<?php

namespace IndicoPlus\CaritasApp\Core;

class Assets
{
    private $plugin_path = '';
    public function __construct(string $plugin_path, string $plugin_file)
    {
        $this->plugin_path = $plugin_path;
        $this->plugin_file = $plugin_file;

        add_action('wp_enqueue_scripts', [$this, 'enqueueAssets']);
    }

    public function enqueueAssets()
    {
        // no manifest
        if (!file_exists($this->plugin_path . 'mix-manifest.json')) {
            return;
        }

        $manifest = json_decode(file_get_contents($this->plugin_path . 'mix-manifest.json'), true);
        // load plugin css
        if (!empty($manifest['/dist/app.css'])) {
            wp_enqueue_style('caritas-app', plugin_dir_url($this->plugin_file) . trim($manifest['/dist/app.css'], '/'), []);
        }

        // load plugin js
        if (!empty($manifest['/dist/app.js'])) {
            if (!wp_script_is('jquery', 'enqueued')) {
                wp_enqueue_script('jquery', "https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js", [], null, true);
            }
            wp_enqueue_script('caritas-app', plugin_dir_url($this->plugin_file) . trim($manifest['/dist/app.js'], '/'), ["jquery"], null, true);
        }
    }
}