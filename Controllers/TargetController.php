<?php

namespace CaritasApp\Controllers;

use CaritasApp\Controllers\Controller;
use CaritasApp\Models\Target;
use CaritasApp\Models\TargetPaymentMethods;
use CaritasApp\Models\TargetsList;

class TargetController extends Controller
{
    const BASE_PATH = '/cele';

    public function index()
    {
        $TargetsList = new TargetsList();
        global $caritas_app_plugin;

        $res = $this->api->get('/targets', [
            'division_id' => $caritas_app_plugin->getSelectedDivision(),
        ]);
        if (!empty($res)) {
            $TargetsList = new TargetsList($res);
        }

        return $this->renderTemplate('targets', [
            'TargetsList' => $TargetsList,
        ]);
    }

    public function show($path)
    {
        $id = $this->cleanPath($path);
        if (!is_numeric($id)) {
            $this->abort();
        }

        $Target = new Target;
        $res = $this->api->get('/targets/' . $id);
        if (!empty($res)) {
            $Target = new Target($res);
        }

        return $this->renderTemplate('target-single', [
            'Target' => $Target,
        ]);
    }

    public function paymentMethods($path)
    {
        // $path = /cele/{id}/wesprzyj
        $path = explode('/', trim($path, '/'));
        $id = $path[1];
        if (!is_numeric($id)) {
            $this->abort();
        }

        $query = [];
        $params = ['detailed_target_id', 'price'];
        foreach ($params as $param) {
            if (!empty($_GET[$param])) {
                $query[$param] = $_GET[$param];
            }
        }

        $TargetPaymentMethods = new TargetPaymentMethods;
        $res = $this->api->get('/targets/' . $id . '/payment-methods', $query);
        if (!empty($res)) {
            $TargetPaymentMethods = new TargetPaymentMethods($res);
        }

        $paymentUrl = null;
        foreach ($TargetPaymentMethods->methods as $method) {
            if ($method->type !== 'bank-transfer') {
                continue;
            }

            $paymentUrl = $method->url;
        }

        if (empty($paymentUrl)) {
            $this->abort();
        }

        return $this->renderTemplate('target-payment-form', [
            'TargetPaymentMethods' => $TargetPaymentMethods,
            'paymentUrl' => $paymentUrl,
        ]);
    }
}
