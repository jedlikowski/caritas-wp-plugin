<?php
namespace IndicoPlus\CaritasApp\Integrations\ElementorWidgets;

use Elementor\Controls_Manager;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Typography;
use IndicoPlus\CaritasApp\Core\DataFetcher;
use IndicoPlus\CaritasApp\Integrations\ElementorWidgets\Widget;

class DetailedTargetsWidget extends Widget
{
    protected $icon = "eicon-price-table";
    protected $title = "Proponowane wpłaty";

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
        if (!$target || !$target->id) {
            return;
        }

        $this->render_template("detailed-targets", [
            'detailed_targets' => $target->detailedTargets,
            'target' => $target,
            'custom_price_enabled' => (bool) intval($settings['custom_price_enabled'] ?? '0'),
            'payment_button_text' => $settings['payment_button_text'] ?? "",
        ]);
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
                'description' => 'Wybierz zbiórkę dla której chcesz wyświetlić proponowane wpłaty',
                'type' => Controls_Manager::SELECT2,
                'default' => 0,
                'options' => $targets_options,
            ]
        );

        $this->add_control(
            'custom_price_enabled',
            [
                'label' => 'Własna kwota',
                'description' => 'Zaznacz, aby pokazać możliwość wpłacenia własnej kwoty',
                'type' => Controls_Manager::SWITCHER,
                'default' => 0,
                'label_on' => 'Tak',
                'label_off' => 'Nie',
                'return_value' => '1',
                'default' => '',
            ]
        );

        $this->add_control(
            'payment_button_text',
            [
                'label' => 'Tekst przycisku',
                'label_block' => true,
                'description' => '',
                'type' => Controls_Manager::TEXT,
                'default' => 'Wspieram',
            ]
        );

        $this->end_controls_section();
    }

    protected function register_style_controls()
    {

        /** GENERAL */
        $this->start_controls_section(
            'general_style_section',
            [
                'label' => 'Ogólne',
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_responsive_control(
            'columns',
            [
                'label' => 'Liczba kolumn',
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 5,
                        'step' => 1,
                    ],
                ],
                'size_units' => ['px'],
                'devices' => ['desktop', 'tablet', 'mobile'],
                'desktop_default' => [
                    'size' => 3,
                    'unit' => 'px',
                ],
                'tablet_default' => [
                    'size' => 2,
                    'unit' => 'px',
                ],
                'mobile_default' => [
                    'size' => 1,
                    'unit' => 'px',
                ],
                'selectors' => [
                    '{{WRAPPER}} .caritas-app-card-item' => 'width: calc(100% / {{SIZE}});',
                ],
            ]
        );

        $this->end_controls_section();

        /** CARD */
        $this->start_controls_section(
            'card_style_section',
            [
                'label' => 'Kafelek',
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'card_bg_color',
            [
                'label' => 'Kolor tła',
                'type' => Controls_Manager::COLOR,
                'default' => '#fbfbfb',
                'selectors' => [
                    '{{WRAPPER}} .caritas-app-card-content' => 'background-color: {{VALUE}}',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'card_box_shadow',
                'label' => 'Cień',
                'selector' => '{{WRAPPER}} .caritas-app-card',
            ]
        );

        $this->add_control(
            'card_color',
            [
                'label' => 'Kolor tekstu',
                'type' => Controls_Manager::COLOR,
                'default' => '#3c3c3c',
                'selectors' => [
                    '{{WRAPPER}} .caritas-app-card-content' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'card_typography',
                'label' => 'Typografia',
                'selector' => '{{WRAPPER}} .caritas-app-card-title',
            ]
        );

        $this->end_controls_section();

        /** AMOUNT */
        $this->start_controls_section(
            'amount_style_section',
            [
                'label' => 'Kwota',
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'amount_bg_color',
            [
                'label' => 'Kolor tła',
                'type' => Controls_Manager::COLOR,
                'default' => '#007bff',
                'selectors' => [
                    '{{WRAPPER}} .caritas-app-card-detailed-ammount' => 'background-color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'amount_color',
            [
                'label' => 'Kolor tekstu',
                'type' => Controls_Manager::COLOR,
                'default' => '#ffffff',
                'selectors' => [
                    '{{WRAPPER}} .caritas-app-card-detailed-ammount' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'amount_typography',
                'label' => 'Typografia',
                'selector' => '{{WRAPPER}} .caritas-app-card-detailed-ammount',
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'amount_border',
                'label' => 'Ramka',
                'selector' => '{{WRAPPER}} .caritas-app-card-detailed-ammount',
            ]
        );

        $this->end_controls_section();

        /** CTA BUTTON */
        $this->start_controls_section(
            'btn_style_section',
            [
                'label' => 'Przycisk wsparcia',
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'btn_bg_color',
            [
                'label' => 'Kolor tła',
                'type' => Controls_Manager::COLOR,
                'default' => '#007bff',
                'selectors' => [
                    '{{WRAPPER}} .caritas-app-card-btn' => 'background-color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'btn_color',
            [
                'label' => 'Kolor tekstu',
                'type' => Controls_Manager::COLOR,
                'default' => '#ffffff',
                'selectors' => [
                    '{{WRAPPER}} .caritas-app-card-btn' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'btn_typography',
                'label' => 'Typografia',
                'selector' => '{{WRAPPER}} .caritas-app-card-btn',
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'btn_border',
                'label' => 'Ramka',
                'selector' => '{{WRAPPER}} .caritas-app-card-btn',
            ]
        );

        $this->end_controls_section();
    }
}
