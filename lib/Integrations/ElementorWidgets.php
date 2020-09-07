<?php

namespace IndicoPlus\CaritasApp\Integrations;

use Elementor\Elements_Manager;
use Elementor\Plugin as ElementorPlugin;
use IndicoPlus\CaritasApp\Integrations\ElementorWidgets\DetailedTargetsWidget;
use IndicoPlus\CaritasApp\Integrations\ElementorWidgets\TargetAttributeWidget;

class ElementorWidgets
{

    const CATEGORY = 'caritas';
    private $widgets = [
        DetailedTargetsWidget::class,
        TargetAttributeWidget::class,
    ];

    public function __construct()
    {
        add_action('plugins_loaded', [$this, 'init']);
    }

    public function init()
    {
        // Check if Elementor is installed and activated
        if (!did_action('elementor/loaded')) {
            return;
        }

        add_action('elementor/elements/categories_registered', [$this, 'add_elementor_widget_categories']);
        add_action('elementor/widgets/widgets_registered', [$this, 'register_elementor_widgets']);
    }

    public function add_elementor_widget_categories(Elements_Manager $elements_manager)
    {
        $elements_manager->add_category(
            static::CATEGORY,
            [
                'title' => __('Caritas', 'caritas-app'),
                'icon' => 'fas fa-hands-helping',
            ],
            1
        );
    }

    public function register_elementor_widgets()
    {
        foreach ($this->widgets as $widget) {
            ElementorPlugin::instance()->widgets_manager->register_widget_type(new $widget());
        }
    }
}
