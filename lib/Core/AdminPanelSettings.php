<?php

namespace IndicoPlus\CaritasApp\Core;

use IndicoPlus\CaritasApp\Core\Api;
use IndicoPlus\CaritasApp\Core\Plugin;
use IndicoPlus\CaritasApp\Core\Router;
use IndicoPlus\CaritasApp\Models\DivisionsList;

class AdminPanelSettings
{
    private $settings = [];
    public function __construct()
    {
        add_action('admin_init', [$this, 'initSettingsPage']);
        $this->settings = get_option('caritas_app_settings') ?: [];
    }

    public function initSettingsPage()
    {

        register_setting('caritas_app_settings_page', 'caritas_app_settings');

        add_settings_section(
            'caritas_app_settings_page_section',
            __('', 'caritas-app'),
            '__return_null',
            'caritas_app_settings_page'
        );

        add_settings_field(
            'selected_division',
            __('Źródło danych', 'caritas-app'),
            [$this, 'renderDivisionsField'],
            'caritas_app_settings_page',
            'caritas_app_settings_page_section'
        );

        add_settings_field(
            'enable_targets_view',
            __('Widok celów/zbiórek', 'caritas-app'),
            [$this, 'renderTargetsEnableField'],
            'caritas_app_settings_page',
            'caritas_app_settings_page_section'
        );

        add_settings_field(
            'enable_news_view',
            __('Widok aktualności', 'caritas-app'),
            [$this, 'renderNewsEnableField'],
            'caritas_app_settings_page',
            'caritas_app_settings_page_section'
        );

        add_settings_field(
            'enable_payments_module',
            __('Moduł płatności', 'caritas-app'),
            [$this, 'renderPaymentsEnableField'],
            'caritas_app_settings_page',
            'caritas_app_settings_page_section'
        );

        add_settings_field(
            'enable_custom_price',
            __('"Własna kwota"', 'caritas-app'),
            [$this, 'renderCustomPriceField'],
            'caritas_app_settings_page',
            'caritas_app_settings_page_section'
        );

        add_settings_field(
            'custom_price_image',
            __('Obrazek kafelka "Własna kwota"', 'caritas-app'),
            [$this, 'renderCustomPriceImageField'],
            'caritas_app_settings_page',
            'caritas_app_settings_page_section'
        );
    }

    public function renderDivisionsField()
    {
        $plugin = Plugin::instance();
        $value = $plugin->getSelectedDivision();
        $divisions = $this->getDivisions();

        $isNoneSelected = selected($value, false, false);
        if ($value && !array_search($value, array_column((array) $divisions, 'id'))) {
            $isNoneSelected = 'selected="selected"';
        }

        echo "<h4 style='padding: 0; margin: 0 0 10px;'>Wybierz oddział Caritas z listy</h4>";
        echo "<select id='caritas_app_settings[selected_division]' name='caritas_app_settings[selected_division]'>";
        echo "<option value='0' {$isNoneSelected} disabled>Nie wybrano</option>";
        foreach ($divisions as $division) {
            $divisionSelected = selected($value, $division->id, false);
            echo "<option value='{$division->id}' {$divisionSelected}>{$division->name}</option>";
        }
        echo "</select>";
        echo '<div style="margin-bottom: 20px"></div>';
        echo "<h4 style='padding: 0; margin: 0 0 10px;'>Lub wprowadź ID ręcznie (zaawansowani użytkownicy)</h4>";
        $textInputValue = $value ?: "";
        echo "<input type='number' value='{$textInputValue}' name='caritas_app_settings[selected_division_manual]' />";
    }

    public function renderNewsEnableField()
    {
        $plugin = Plugin::instance();
        $value = intval($plugin->isNewsViewEnabled());
        ?>
<select name='caritas_app_settings[enable_news_view]'>
  <option value='1' <?php selected($value, 1);?>>Włączony</option>
  <option value='0' <?php selected($value, 0);?>>Wyłączony</option>
</select>
<?php

        $url = home_url(Router::NEWS_PATH);
        $this->renderHelpText("Włącza moduł aktualności pod adresami:");
        $this->renderHelpText("$url - lista aktualności");
        $this->renderHelpText("$url/{id} - pojedynczy artykuł");
    }

    public function renderTargetsEnableField()
    {
        $plugin = Plugin::instance();
        $value = intval($plugin->isTargetsViewEnabled());
        ?>
<select name='caritas_app_settings[enable_targets_view]'>
  <option value='1' <?php selected($value, 1);?>>Włączony</option>
  <option value='0' <?php selected($value, 0);?>>Wyłączony</option>
</select>
<?php

        $url = home_url(Router::TARGETS_PATH);
        $this->renderHelpText("Włącza moduł celów/zbiórek pod adresami:");
        $this->renderHelpText("$url - lista celów");
        $this->renderHelpText("$url/{id} - pojedynczy cel");
    }

    public function renderPaymentsEnableField()
    {
        $plugin = Plugin::instance();
        $value = intval($plugin->isPaymentsModuleEnabled());
        ?>
<select name='caritas_app_settings[enable_payments_module]'>
  <option value='1' <?php selected($value, 1);?>>Włączony</option>
  <option value='0' <?php selected($value, 0);?>>Wyłączony</option>
</select>
<?php

        $targets_url = home_url(Router::TARGETS_PATH);
        $execute_payment_url = home_url(Router::BANK_TRANSFER_PATH);
        $payment_success_url = home_url(Router::PAYMENT_SUCCESS_PATH);
        $payment_error_url = home_url(Router::PAYMENT_ERROR_PATH);
        $this->renderHelpText("Włącza moduł płatności pod adresami:");
        $this->renderHelpText("$targets_url/{id}/wesprzyj - formularz wsparcia celu/zbiórki");
        $this->renderHelpText("$payment_success_url - widok sukcesu płatności");
        $this->renderHelpText("$payment_error_url - widok nieudanej płatności");
        $this->renderHelpText("$execute_payment_url - przekierowanie do dostawcy płatności");
    }

    public function renderCustomPriceField()
    {
        $options = $this->settings;
        $is_selected = empty($options['enable_custom_price']) ? 0 : $options['enable_custom_price'];
        ?>
<select name='caritas_app_settings[enable_custom_price]'>
  <option value='1' <?php selected($is_selected, 1);?>>Pokaż</option>
  <option value='0' <?php selected($is_selected, 0);?>>Ukryj</option>
</select>
<?php

        $this->renderHelpText("Włącza kafelek 'Własna kwota' jako jedna z proponowanych wpłat.");
    }

    public function renderCustomPriceImageField()
    {
        $plugin = Plugin::instance();
        $options = $this->settings;
        $default_src = plugin_dir_url($plugin->plugin_file) . 'img/inna-kwota.jpg';
        $url = empty($options['custom_price_image']) ? $default_src : $options['custom_price_image'];
        ?>

<div class="caritas-app-media-input">
  <img data-action="upload" src="<?php echo $url; ?>" data-default-src="<?php echo $default_src; ?>"
    style="cursor: pointer; margin-top: 7px; max-width: 300px; max-height: 300px; display: block;"
    alt="Plik nie istnieje" />
  <input type="hidden" name="caritas_app_settings[custom_price_image]" value="<?php echo $url; ?>"
    style="min-width: 300px;" />
  <div style="margin-top: 10px;">
    <button data-action="upload" type="button" class="button-primary">
      <?php echo empty($options['custom_price_image']) ? "Wybierz obraz" : "Zmień obraz"; ?>
    </button>
    <?php if (!empty($options['custom_price_image'])) {?>
    <button data-action="clear" type="button" class="button-secondary">
      Usuń obraz
    </button>
    <?php }?>
    <p>
      W przypadku braku wybranego obrazka wtyczka będzie używać <a href="<?php echo $default_src; ?>" target="_blank"
        rel="noopener">tego</a>
      pliku.
    </p>
  </div>
</div>
<?php
}

    public function renderHelpText(string $text)
    {
        echo '<p>' . $text . '</p>';
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
