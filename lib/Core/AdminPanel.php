<?php

namespace IndicoPlus\CaritasApp\Core;

use IndicoPlus\CaritasApp\Core\AdminPanelSettings;
use IndicoPlus\CaritasApp\Core\Plugin;

class AdminPanel
{
    private $main_page_key = 'aplikacja-caritas';
    private $settings_page_key = 'ustawienia-aplikacji-caritas';
    private $docs_page_key = 'dokumentacja-aplikacji-caritas';
    private $iframe_url = Api::BASE_PATH . '/cms';

    public function __construct()
    {
        add_action('admin_menu', [$this, 'registerAdminPages']);
        new AdminPanelSettings();
    }

    public function registerAdminPages()
    {
        add_menu_page(
            'Aplikacja Caritas',
            'Aplikacja Caritas',
            'edit_posts',
            $this->main_page_key,
            [$this, 'renderCMSPage'],
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

        add_submenu_page(
            $this->main_page_key,
            'Dokumentacja',
            'Dokumentacja',
            'edit_posts',
            $this->docs_page_key,
            [$this, 'renderDocsPage']
        );
    }

    public function renderCMSPage()
    {
        return $this->renderTemplate('cms', [
            'iframe_url' => $this->iframe_url,
        ]);
    }

    public function renderSettingsPage()
    {
        $plugin = Plugin::instance();

        return $this->renderTemplate('settings', [
            'targets_view_enabled' => $plugin->isTargetsViewEnabled(),
            'news_view_enabled' => $plugin->isNewsViewEnabled(),
            'selected_division' => $plugin->getSelectedDivision(),
        ]);

    }

    public function renderDocsPage()
    {
        return $this->renderTemplate('docs');
    }

    private function renderTemplate(string $template = null, array $variables = [])
    {
        $plugin = Plugin::instance();

        // Define any data variables which will be used by the template
        foreach ($variables as $variable => $value) {
            $$variable = $value;
        }

        // get path to basic template from the plugin directory
        $template_path = $plugin->plugin_path . 'templates-admin/' . $template . '.php';

        if (!file_exists($template_path)) {
            wp_die('Caritas App plugin is missing admin <strong>' . $template . '.php</strong> template!');
        }

        require_once $template_path;
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
