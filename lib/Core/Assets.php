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
        add_action('admin_enqueue_scripts', [$this, 'enqueueAdminAssets']);
    }

    public function enqueueAssets()
    {
        $manifest = $this->readManifest();
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
    public function enqueueAdminAssets()
    {
        $manifest = $this->readManifest();

        // load plugin admin js
        if (!empty($manifest['/dist/admin.js'])) {
            wp_enqueue_media();
            wp_enqueue_script('caritas-app-admin', plugin_dir_url($this->plugin_file) . trim($manifest['/dist/admin.js'], '/'), ["jquery"], null, true);
        }
    }

    private function readManifest(): array
    {
        $maanifest_path = $this->plugin_path . 'mix-manifest.json';
        // no manifest
        if (!file_exists($maanifest_path)) {
            return [];
        }

        $manifest = json_decode(file_get_contents($maanifest_path), true);
        return is_array($manifest) ? $manifest : [];
    }
}