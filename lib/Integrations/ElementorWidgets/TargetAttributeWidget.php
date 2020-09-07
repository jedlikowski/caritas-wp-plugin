<?php
namespace IndicoPlus\CaritasApp\Integrations\ElementorWidgets;

use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use IndicoPlus\CaritasApp\Core\DataFetcher;
use IndicoPlus\CaritasApp\Integrations\ElementorWidgets\Widget;

class TargetAttributeWidget extends Widget
{
    protected $icon = "eicon-meta-data";
    protected $title = "Dane zbiórki";

    protected function _register_controls()
    {
        $this->register_content_controls();
        $this->register_style_controls();
    }

    public function render()
    {
        $settings = $this->get_settings_for_display();
        if (empty($settings['target']) || !is_numeric($settings['target'])) {
            return;
        }
        $target = DataFetcher::getTarget($settings['target']);

        $attribute = $settings['attribute'];
        if (!isset($target->{$attribute})) {
            return;
        }

        $value = $target->{$attribute};
        echo '<div class="caritas-app-target-attribute">' . $value . '</div>';
    }

    protected function register_content_controls()
    {
        $this->start_controls_section(
            'content_section',
            [
                'label' => $this->title,
                'tab' => Controls_Manager::TAB_CONTENT,
            ]
        );

        $targets_options = [];

        // fetch data only in wp-admin context
        if (is_admin()) {
            $targets_list = DataFetcher::getTargetsList();
            foreach ($targets_list->targets as $target) {
                $targets_options[$target->id] = $target->name;
            }
        }
        $this->add_control(
            'target',
            [
                'label' => 'Zbiórka',
                'label_block' => true,
                'description' => 'Wybierz zbiórkę, z której chcesz wyświetlić dane',
                'type' => Controls_Manager::SELECT2,
                'default' => 0,
                'options' => $targets_options,
            ]
        );

        $this->add_control(
            'attribute',
            [
                'label' => 'Atrybut',
                'label_block' => true,
                'description' => 'Wybierz atrybut, który chcesz wyświetlić',
                'type' => Controls_Manager::SELECT,
                'default' => 'title',
                'options' => [
                    'id' => "ID",
                    'name' => "Nazwa",
                    'description' => 'Opis',
                    'payments' => 'Liczba wpłat',
                    'target_amount' => 'Kwota docelowa',
                    'collected_amount' => 'Zebrana kwota',
                ],
            ]
        );

        $this->end_controls_section();
    }

    protected function register_style_controls()
    {
        $this->start_controls_section(
            'general_style_section',
            [
                'label' => 'Ogólne',
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'general_color',
            [
                'label' => 'Kolor tekstu',
                'type' => Controls_Manager::COLOR,
                'default' => '#3c3c3c',
                'selectors' => [
                    '{{WRAPPER}} .caritas-app-target-attribute' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'general_typography',
                'label' => 'Typografia',
                'selector' => '{{WRAPPER}} .caritas-app-target-attribute',
            ]
        );

        $this->end_controls_section();
    }
}
