<?php

namespace IndicoPlus\CaritasApp\Core;

use IndicoPlus\CaritasApp\Core\Api;
use IndicoPlus\CaritasApp\Models\DivisionsList;

class AdminPanelSettings
{
    public function __construct()
    {
        add_action('admin_init', [$this, 'initSettingsPage']);
    }

    public function initSettingsPage()
    {

        register_setting('caritas_app_settings_page', 'caritas_app_settings');

        add_settings_section(
            'caritas_app_settings_page_section',
            __('Settings', 'caritas-app'),
            '__return_null',
            'caritas_app_settings_page'
        );

        add_settings_field(
            'selected_division',
            __('Z której Caritas powinniśmy wyświetlać dane?', 'caritas-app'),
            [$this, 'renderDivisionsField'],
            'caritas_app_settings_page',
            'caritas_app_settings_page_section'
        );

        add_settings_field(
            'enable_targets_view',
            __('Moduł celów/zbiórek jest aktywny', 'caritas-app'),
            [$this, 'renderTargetsEnableField'],
            'caritas_app_settings_page',
            'caritas_app_settings_page_section'
        );

        add_settings_field(
            'enable_news_view',
            __('Moduł aktualności jest aktywny', 'caritas-app'),
            [$this, 'renderNewsEnableField'],
            'caritas_app_settings_page',
            'caritas_app_settings_page_section'
        );

        add_settings_field(
            'enable_custom_price',
            __('Pokaż opcję "Własna kwota" w proponowanych wpłatach', 'caritas-app'),
            [$this, 'renderCustomPriceField'],
            'caritas_app_settings_page',
            'caritas_app_settings_page_section'
        );
    }

    public function renderDivisionsField()
    {
        global $caritas_app_plugin;
        $value = $caritas_app_plugin->getSelectedDivision();
        $divisions = $this->getDivisions();
        $isDefaultSelected = selected($value, false, false);

        echo "<select id='caritas_app_settings[selected_division]' name='caritas_app_settings[selected_division]'>";
        echo "<option value='0' {$isDefaultSelected} disabled>Nie wybrano</option>";
        foreach ($divisions as $division) {
            $divisionSelected = selected($value, $division->id, false);
            echo "<option value='{$division->id}' {$divisionSelected}>{$division->name}</option>";
        }
        echo "</select>";
    }

    public function renderNewsEnableField()
    {
        $options = get_option('caritas_app_settings');
        ?>
<select name='caritas_app_settings[enable_news_view]'>
  <option value='1' <?php selected($options['enable_news_view'], 1);?>>Tak</option>
  <option value='0' <?php selected($options['enable_news_view'], 0);?>>Nie</option>
</select>
<?php
}

    public function renderTargetsEnableField()
    {
        $options = get_option('caritas_app_settings');
        ?>
<select name='caritas_app_settings[enable_targets_view]'>
  <option value='1' <?php selected($options['enable_targets_view'], 1);?>>Tak</option>
  <option value='0' <?php selected($options['enable_targets_view'], 0);?>>Nie</option>
</select>
<?php
}

    public function renderCustomPriceField()
    {
        $options = get_option('caritas_app_settings');
        $is_selected = empty($options['enable_custom_price']) ? 0 : $options['enable_custom_price'];
        ?>
<select name='caritas_app_settings[enable_custom_price]'>
  <option value='1' <?php selected($is_selected, 1);?>>Tak</option>
  <option value='0' <?php selected($is_selected, 0);?>>Nie</option>
</select>
<?php
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
}