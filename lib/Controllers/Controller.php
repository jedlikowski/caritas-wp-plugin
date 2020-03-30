<?php

namespace IndicoPlus\CaritasApp\Controllers;

use IndicoPlus\CaritasApp\Core\Api;

class Controller
{
    const BASE_PATH = '/example-route';

    protected $api = null;

    public function __construct()
    {
        global $caritas_app_plugin;
        $this->api = $caritas_app_plugin->getApiInstance();
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

        return $caritas_app_plugin->renderTemplate($template, $variables);
    }
}
