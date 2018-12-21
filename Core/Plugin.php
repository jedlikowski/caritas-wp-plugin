<?php

namespace CaritasApp\Core;

use CaritasApp\Core\AdminPanel;
use CaritasApp\Core\Router;

class Plugin
{
    public $plugin_path;
    private $optionName = 'caritas_app_selected_division';
    private $selectedDivision = null;

    public function __construct($plugin_path)
    {
        $this->plugin_path = $plugin_path;
        new Router();
        new AdminPanel();

        $this->getSelectedDivision();
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
}
