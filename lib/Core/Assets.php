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

        // load plugin css
        if (!empty($manifest['/dist/app.css'])) {
            wp_enqueue_script('caritas-app', plugin_dir_url($this->plugin_file) . trim($manifest['/dist/app.css'], '/'), [], null, true);
        }
    }
}