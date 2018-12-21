<?php
namespace CaritasApp\Core;

use CaritasApp\Controllers\NewsController;
use CaritasApp\Controllers\PaymentController;
use CaritasApp\Controllers\TargetController;
use jedlikowski\WP_Router\Router as WP_Router;

class Router
{
    const NEWS_PATH = '/aktualnosci';
    const TARGETS_PATH = '/cele';
    const BANK_TRANSFER_PATH = '/bank-transfer-payment';
    const PAYMENT_SUCCESS_PATH = '/platnosc-zakonczona';
    const PAYMENT_ERROR_PATH = '/blad-platnosci';

    public function __construct()
    {
        // Define mock routes to not create fake pages for each route
        try {
            $router = new WP_Router([
                static::NEWS_PATH . '/*' => NewsController::class . "@show",
                static::NEWS_PATH => NewsController::class . "@index",
                static::TARGETS_PATH . '/*/wesprzyj' => TargetController::class . "@paymentMethods",
                static::TARGETS_PATH . '/*' => TargetController::class . "@show",
                static::TARGETS_PATH => TargetController::class . "@index",
                static::BANK_TRANSFER_PATH => PaymentController::class . "@processBankTransfer",
                static::PAYMENT_SUCCESS_PATH => PaymentController::class . "@paymentSuccess",
                static::PAYMENT_ERROR_PATH => PaymentController::class . "@paymentError",
            ]);
        } catch (\Exception $e) {
            wp_die($e->getMessage());
        }
    }
}
