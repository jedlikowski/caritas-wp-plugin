<?php

namespace IndicoPlus\CaritasApp\Core;

use Puc_v4_Factory;

class Updater
{
    private $updater = null;

    public function __construct(string $plugin_path)
    {
        $this->updater = Puc_v4_Factory::buildUpdateChecker(
            'https://github.com/jedlikowski/caritas-wp-plugin/',
            $plugin_path,
            'caritas-wp-plugin'
        );
        $this->updater->getVcsApi()->enableReleaseAssets();
    }
}