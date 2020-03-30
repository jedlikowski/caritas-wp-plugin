<?php

namespace IndicoPlus\CaritasApp\Models;

class TargetPaymentMethods
{
    public $target = '';
    public $detailed_target = '';
    public $tos_url = '';
    public $methods = [];

    public function __construct($json = null)
    {
        if (empty($json) || !is_object($json)) {
            return;
        }

        $this->target = empty($json->target) ? '' : $json->target;
        $this->detailed_target = empty($json->detailed_target) ? '' : $json->detailed_target;
        $this->tos_url = empty($json->tos_url) ? '' : $json->tos_url;

        if (!empty($json->methods) && is_array($json->methods)) {
            $this->methods = $json->methods;
        }
    }
}
