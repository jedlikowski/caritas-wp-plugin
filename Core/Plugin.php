<?php

namespace CaritasApp\Core;

use CaritasApp\Core\AdminPanel;
use CaritasApp\Core\Api;
use CaritasApp\Core\Router;

class Plugin
{
    public $plugin_path;
    private $activationTransientName = 'caritas-app-activation-notice-transient';
    private $selectedDivision = null;
    private $targetsViewEnabled = false;
    private $newsViewEnabled = false;
    private $router = null;
    private $api = null;
    private $adminPanel = null;

    public function __construct($plugin_path)
    {
        $this->loadSettings();

        $this->plugin_path = $plugin_path;
        $this->adminPanel = new AdminPanel();
        $this->api = new Api();

        if ($this->getSelectedDivision()) {
            $this->router = new Router([
                'targets_enabled' => $this->isTargetsViewEnabled(),
                'news_enabled' => $this->isNewsViewEnabled(),
            ]);
        }

        add_action('admin_notices', [$this, 'showActivationAdminNotice']);
    }

    public function getSelectedDivision()
    {
        return $this->selectedDivision;
    }

    public function isTargetsViewEnabled()
    {
        return $this->targetsViewEnabled ? true : false;
    }

    public function isNewsViewEnabled()
    {
        return $this->newsViewEnabled ? true : false;
    }

    public function handleActivation()
    {

        set_transient($this->activationTransientName, true, 5);
    }

    public function showActivationAdminNotice()
    {
        /* Check transient, if available display notice */
        if (!get_transient($this->activationTransientName)) {
            return;
        }

        echo "
<div class='updated notice is-dismissible'>
    <p>Po aktywacji wtyczki <strong>Aplikacji Caritas</strong> należy wybrać Caritas, z której dane będą wyświetlane na stronie.</p>
    <p>Aby to zrobić, przejdź pod <a href='{$this->adminPanel->getSettingsPageUrl()}'>ten link</a>.</p>
</div>
        ";
        /* Delete transient, only display this notice once. */
        delete_transient($this->activationTransientName);
    }

    public function loadSettings()
    {
        $options = get_option('caritas_app_settings');

        if (!empty($options['selected_division']) && is_numeric($options['selected_division'])) {
            $this->selectedDivision = intval($options['selected_division']);
        } else {
            $this->selectedDivision = null;
        }

        if (isset($options['enable_targets_view']) && is_numeric($options['enable_targets_view'])) {
            $this->targetsViewEnabled = (bool) intval($options['enable_targets_view']);
        } else {
            $this->targetsViewEnabled = false;
        }

        if (isset($options['enable_news_view']) && is_numeric($options['enable_news_view'])) {
            $this->newsViewEnabled = (bool) intval($options['enable_news_view']);
        } else {
            $this->newsViewEnabled = false;
        }
    }

    public function renderTemplate(string $template = null, array $variables = [])
    {
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
        $template_path = $this->plugin_path . 'templates/' . $template . '.php';

        if (!file_exists($template_path)) {
            wp_die('Caritas App  plugin is missing <strong>' . $template . '.php</strong> template!');
        }

        require_once $template_path;

    }

    public function getApiInstance()
    {
        if (empty($this->api)) {
            $this->api = new Api();
        }

        return $this->api;
    }
}