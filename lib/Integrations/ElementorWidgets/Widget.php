<?php
namespace IndicoPlus\CaritasApp\Integrations\ElementorWidgets;

use Elementor\Widget_Base;
use IndicoPlus\CaritasApp\Core\Plugin;

class Widget extends Widget_Base
{
    protected $title = '';
    protected $icon = '';

    public function get_name()
    {
        return str_replace('\\', '_', strtolower(static::class));
    }

    public function get_title()
    {
        return $this->title;
    }

    public function get_categories()
    {
        return ['caritas'];
    }

    public function get_icon()
    {
        if (!empty($this->icon)) {
            return $this->icon;
        }

        return parent::get_icon();
    }

    protected function render_template(string $template = null, array $variables = [])
    {
        $plugin = Plugin::instance();

        // Define any data variables which will be used by the template
        foreach ($variables as $variable => $value) {
            $$variable = $value;
        }

        // get path to basic template from the plugin directory
        $template_path = $plugin->plugin_path . 'templates-widgets/' . $template . '.php';

        if (!file_exists($template_path)) {
            wp_die('Caritas App plugin is missing widget <strong>' . $template . '.php</strong> template!');
        }

        require_once $template_path;
    }
}
