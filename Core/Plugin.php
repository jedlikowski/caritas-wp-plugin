<?php

namespace CaritasApp\Core;

use CaritasApp\Core\AdminPanel;
use CaritasApp\Core\Router;

class Plugin
{
    public $plugin_path;
    private $optionName = 'caritas_app_selected_division';
    private $transientName = 'caritas-app-activation-notice-transient';
    private $selectedDivision = null;
    private $router = null;
    private $adminPanel = null;

    public function __construct($plugin_path)
    {
        $this->plugin_path = $plugin_path;
        $this->router = new Router();
        $this->adminPanel = new AdminPanel();

        $this->getSelectedDivision();

        add_action('admin_notices', [$this, 'handleAdminNotices']);
    }

    public function getSelectedDivision()
    {
        if (!$this->selectedDivision) {
            $value = get_option($this->optionName, null);
            if ($value !== null && is_numeric($value)) {
                $this->selectedDivision = intval($value);
            }
        }

        return $this->selectedDivision;
    }

    public function setSelectedDivision($division)
    {
        if (!is_numeric($division)) {
            return;
        }

        $division = intval($division);
        update_option($this->optionName, $division);
        $this->selectedDivision = $division;

        return $this->selectedDivision;
    }

    public function handleActivation()
    {
        set_transient($this->transientName, true, 5);
    }

    public function handleAdminNotices()
    {
        /* Check transient, if available display notice */
        if (get_transient($this->transientName)) {
            ?>
        <div class="updated notice is-dismissible">
            <p>Po aktywacji wtyczki należy wybrać Caritas, z której dane będą wyświetlane na stronie.</p>
            <p>Aby to zrobić, przejdź pod <a href="<?php echo $this->adminPanel->getSettingsPageUrl(); ?>">ten link</a></p>
        </div>
        <?php
/* Delete transient, only display this notice once. */
            delete_transient($this->transientName);
        }
    }
}
