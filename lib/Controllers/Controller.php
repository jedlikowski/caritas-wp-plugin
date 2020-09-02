<?php

namespace IndicoPlus\CaritasApp\Controllers;

use IndicoPlus\CaritasApp\Core\Api;
use IndicoPlus\CaritasApp\Core\Plugin;

class Controller
{
    const BASE_PATH = '/example-route';

    protected $api = null;

    public function __construct()
    {
        $plugin = Plugin::instance();
        $this->api = $plugin->getApiInstance();
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
        $plugin = Plugin::instance();

        return $plugin->renderTemplate($template, $variables);
    }
}
