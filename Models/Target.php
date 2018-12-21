<?php

namespace CaritasApp\Models;

use CaritasApp\Models\DetailedTarget;
use CaritasApp\Models\Photo;

class Target
{
    public $id = null;
    public $name = '';
    public $description = '';
    public $gallery = [];

    public function __construct($json = null)
    {
        if (empty($json) || !is_object($json)) {
            return;
        }

        $this->id = empty($json->id) ? '' : $json->id;
        $this->name = empty($json->name) ? '' : $json->name;
        $this->description = empty($json->description) ? '' : $json->description;

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
        return '/image.jpg';
    }

    public function getPaymentFormUrl(int $detailedTargetId = null, int $price = null)
    {
        return site_url('/cele/' . $this->id . '/wesprzyj?' . http_build_query([
            'detailed_target_id' => $detailedTargetId,
            'price' => $price,
        ]));
    }
}
