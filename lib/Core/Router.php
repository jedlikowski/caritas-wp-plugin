<?php
namespace IndicoPlus\CaritasApp\Core;

use IndicoPlus\CaritasApp\Controllers\NewsController;
use IndicoPlus\CaritasApp\Controllers\PaymentController;
use IndicoPlus\CaritasApp\Controllers\TargetController;
use jedlikowski\WP_Router\Router as WP_Router;

class Router
{
    const NEWS_PATH = '/aktualnosci';
    const TARGETS_PATH = '/cele';
    const BANK_TRANSFER_PATH = '/bank-transfer-payment';
    const PAYMENT_SUCCESS_PATH = '/platnosc-zakonczona';
    const PAYMENT_ERROR_PATH = '/blad-platnosci';

    public function __construct(array $options = [])
    {
        $options = wp_parse_args($options, [
            'targets_enabled' => true,
            'news_enabled' => true,
        ]);

        $routes = [];
        if ($options['targets_enabled']) {
            $routes[static::TARGETS_PATH . '/*/wesprzyj'] = TargetController::class . "@paymentMethods";
            $routes[static::TARGETS_PATH . '/*'] = TargetController::class . "@show";
            $routes[static::TARGETS_PATH] = TargetController::class . "@index";
            $routes[static::BANK_TRANSFER_PATH] = PaymentController::class . "@processBankTransfer";
            $routes[static::PAYMENT_SUCCESS_PATH] = PaymentController::class . "@paymentSuccess";
            $routes[static::PAYMENT_ERROR_PATH] = PaymentController::class . "@paymentError";
        }

        if ($options['news_enabled']) {
            $routes[static::NEWS_PATH . '/*'] = NewsController::class . "@show";
            $routes[static::NEWS_PATH] = NewsController::class . "@index";
        }

        try {
            $router = new WP_Router($routes);
        } catch (\Exception $e) {
            wp_die($e->getMessage());
        }
    }
}
