<?php

namespace CaritasApp\Core;

use CaritasApp\Core\Api;
use CaritasApp\Models\DivisionsList;

class AdminPanel
{
    private $main_page_key = 'aplikacja-caritas';
    private $settings_page_key = 'ustawienia-aplikacji-caritas';
    private $iframe_url = Api::BASE_PATH . '/cms';

    public function __construct()
    {
        add_action('admin_menu', [$this, 'registerAdminPages']);
    }

    public function registerAdminPages()
    {
        add_menu_page(
            'Aplikacja Caritas',
            'Aplikacja Caritas',
            'edit_posts',
            $this->main_page_key,
            [$this, 'renderMainPage'],
            'dashicons-smartphone',
            6
        );

        add_submenu_page(
            $this->main_page_key,
            'Ustawienia',
            'Ustawienia',
            'manage_options',
            $this->settings_page_key,
            [$this, 'renderSettingsPage']
        );
    }

    public function renderMainPage()
    {
        return $this->renderTemplate('home', [
            'iframe_url' => $this->iframe_url,
        ]);
    }

    public function renderSettingsPage()
    {
        global $caritas_app_plugin;
        if (!empty($_POST) && !empty($_POST['division'])) {
            if (!isset($_POST['_wpnonce']) || !wp_verify_nonce($_POST['_wpnonce'], 'caritas-app-division-save')) {
                wp_die('Nie masz uprawnień do zmiany Caritas');
            }

            $caritas_app_plugin->setSelectedDivision($_POST['division']);
        }

        return $this->renderTemplate('settings', [
            'divisions' => $this->getDivisions(),
            'selected_division' => $caritas_app_plugin->getSelectedDivision(),
        ]);
    }

    private function renderTemplate(string $template = null, array $variables = [])
    {
        global $caritas_app_plugin;

        // Define any data variables which will be used by the template
        foreach ($variables as $variable => $value) {
            $$variable = $value;
        }

        // get path to basic template from the plugin directory
        $template_path = $caritas_app_plugin->plugin_path . 'templates-admin/' . $template . '.php';

        if (!file_exists($template_path)) {
            wp_die('Caritas App  plugin is missing admin <strong>' . $template . '.php</strong> template!');
        }

        require_once $template_path;
    }

    private function getDivisions()
    {
        $api = new Api();
        $DivisionsList = new DivisionsList;
        $res = $api->get('/divisions');
        if (!empty($res)) {
            $DivisionsList = new DivisionsList($res);
        }

        return $DivisionsList->divisions;
    }

    public function getMainPageUrl()
    {
        return menu_page_url($this->main_page_key, false);
    }

    public function getSettingsPageUrl()
    {
        return menu_page_url($this->settings_page_key, false);
    }
}
