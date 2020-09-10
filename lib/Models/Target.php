<?php

namespace IndicoPlus\CaritasApp\Models;

use IndicoPlus\CaritasApp\Core\Plugin;
use IndicoPlus\CaritasApp\Models\DetailedTarget;
use IndicoPlus\CaritasApp\Models\Photo;

class Target
{
    public $id = null;
    public $name = '';
    public $description = '';
    public $gallery = [];
    public $detailedTargets = [];
    public $payments = 0;
    public $target_amount = 0;
    public $collected_amount = 0;

    public function __construct($json = null)
    {
        if (empty($json) || !is_object($json)) {
            return;
        }

        $this->id = empty($json->id) ? '' : $json->id;
        $this->name = empty($json->name) ? '' : $json->name;
        $this->description = empty($json->description) ? '' : $json->description;
        $this->payments = empty($json->payments) ? 0 : intval($json->payments);
        $this->target_amount = empty($json->target_amount) ? 0 : intval($json->target_amount);
        $this->collected_amount = empty($json->collected_amount) ? 0 : intval($json->collected_amount);

        if (!empty($json->gallery) && is_array($json->gallery)) {
            $this->gallery = array_map(function ($item) {
                return new Photo($item);
            }, $json->gallery);
        }

        if (!empty($json->detailedTargets) && is_array($json->detailedTargets)) {
            $this->detailedTargets = array_map(function ($item) {
                return new DetailedTarget($item);
            }, $json->detailedTargets);
        }
    }

    public function getCustomPricePhotoUrl()
    {
        $plugin = Plugin::instance();
        return $plugin->getCustomPricePhotoUrl();

    }

    public function getPaymentFormUrl(int $detailedTargetId = null, int $price = null)
    {
        return home_url('/cele/' . $this->id . '/wesprzyj?' . http_build_query([
            'detailed_target_id' => $detailedTargetId,
            'price' => $price,
        ]));
    }
}
