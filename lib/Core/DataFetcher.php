<?php

namespace IndicoPlus\CaritasApp\Core;

use IndicoPlus\CaritasApp\Core\Api;
use IndicoPlus\CaritasApp\Core\Plugin;
use IndicoPlus\CaritasApp\Models\Target;
use IndicoPlus\CaritasApp\Models\TargetPaymentMethods;
use IndicoPlus\CaritasApp\Models\TargetsList;

class DataFetcher
{
    public static function getTargetsList()
    {
        $plugin = Plugin::instance();
        $api = Api::instance();

        $res = $api->get('/targets', [
            'division_id' => $plugin->getSelectedDivision(),
        ]);
        if (empty($res)) {
            return new TargetsList;
        }

        return new TargetsList($res);
    }

    public static function getTarget(int $id)
    {
        $api = Api::instance();
        if (!is_numeric($id)) {
            return null;
        }

        $res = $api->get('/targets/' . $id);
        if (empty($res)) {
            return null;
        }

        return new Target($res);
    }

    public static function getTargetPaymentMethods(int $targetId, array $additional = [])
    {
        $returnValue = (object) [
            'TargetPaymentMethods' => new TargetPaymentMethods,
            'paymentUrl' => null,
        ];
        $query = [];
        $params = ['detailed_target_id', 'price'];
        foreach ($params as $param) {
            if (empty($additional[$param])) {
                continue;
            }

            $query[$param] = $additional[$param];
        }

        $api = Api::instance();
        $res = $api->get('/targets/' . $targetId . '/payment-methods', $query);
        if (!empty($res)) {
            $returnValue->TargetPaymentMethods = new TargetPaymentMethods($res);
        }

        foreach ($returnValue->TargetPaymentMethods->methods as $method) {
            if ($method->type !== 'bank-transfer') {
                continue;
            }
            $returnValue->paymentUrl = $method->url;
        }

        return $returnValue;
    }
}
