<?php

namespace IndicoPlus\CaritasApp\Controllers;

use IndicoPlus\CaritasApp\Controllers\Controller;
use IndicoPlus\CaritasApp\Core\Router;

class TargetController extends Controller
{
    const BASE_PATH = Router::TARGETS_PATH;

    public function index()
    {
        return $this->renderTemplate('targets', [
            'TargetsList' => caritas_app_get_targets_list(),
        ]);
    }

    public function show($path)
    {
        $id = $this->cleanPath($path);
        $Target = caritas_app_get_target($id);

        if (!$Target || !$Target->id) {
            $this->abort();
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

        $data = caritas_app_get_target_payment_methods(intval($id), $_GET);

        if (!$data || empty($data->paymentUrl)) {
            $this->abort();
        }

        return $this->renderTemplate('target-payment-form', [
            'TargetPaymentMethods' => $data->TargetPaymentMethods,
            'paymentUrl' => $data->paymentUrl,
        ]);
    }
}
