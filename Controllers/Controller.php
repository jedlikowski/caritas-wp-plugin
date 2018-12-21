<?php

namespace CaritasApp\Controllers;

use CaritasApp\Core\Api;

class Controller
{
    const BASE_PATH = '/example-route';

    protected $api = null;

    public function __construct()
    {
        $this->api = new Api();
    }

    public function index()
    {
        echo "example index route";
    }

    public function show($path)
    {
        echo "example details route";
    }

    protected function cleanPath(string $path = '')
    {
        return trim(str_replace(static::BASE_PATH, '', $path), '/');
    }

    public function abort(int $errorCode = 404, $show404Page = true)
    {
        global $wp_query;
        $wp_query->posts = [];
        status_header($errorCode);

        if ($errorCode === 404) {
            $wp_query->set_404();

            if ($show404Page) {
                get_template_part(404);
            }
        }
        exit;
    }

    public function renderTemplate(string $template = null, array $variables = [])
    {
        global $caritas_app_plugin;

        // Define any data variables which will be used by the template
        foreach ($variables as $variable => $value) {
            $$variable = $value;
        }

        // Allow themes to define custom templates
        $custom_template_path = locate_template('caritas-app-templates/' . $template . '.php', false, false);
        if (!empty($custom_template_path)) {
            require_once $custom_template_path;
            return;
        }

        // get path to basic template from the plugin directory
        $template_path = $caritas_app_plugin->plugin_path . 'templates/' . $template . '.php';

        if (!file_exists($template_path)) {
            wp_die('Caritas App  plugin is missing <strong>' . $template . '.php</strong> template!');
        }

        require_once $template_path;
    }
}
