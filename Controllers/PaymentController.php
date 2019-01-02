<?php

namespace CaritasApp\Controllers;

use CaritasApp\Controllers\Controller;
use CaritasApp\Core\Router;

class PaymentController extends Controller
{
    public function processBankTransfer()
    {
        $data = [
            'price' => 0,
            'name' => '',
            'email' => '',
        ];

        $data['price'] = empty($_POST['price']) ? $data['price'] : caritas_app_parse_formatted_price($_POST['price']);
        $data['name'] = empty($_POST['name']) ? $data['name'] : $_POST['name'];
        $data['email'] = empty($_POST['email']) ? $data['email'] : $_POST['email'];

        $res = $this->api->post($_POST['payment_url'], $data);

        if (empty($res) || empty($res->url)) {
            wp_die('Coś poszło nie tak przy inicjalizacji płatności.');
        }

        $urlParts = wp_parse_url($res->url);

        // failed to parse payment redirection url, show error view
        if (empty($urlParts)) {
            wp_redirect(site_url(Router::PAYMENT_ERROR_PATH));
            return;
        }

        // prepare payment redirection url received from the API by adding custom success and error urls
        $returnUrlQuery = http_build_query([
            'success_url' => site_url(Router::PAYMENT_SUCCESS_PATH),
            'error_url' => site_url(Router::PAYMENT_ERROR_PATH),
        ]);

        if (empty($urlParts['query'])) {
            $urlParts['query'] = $returnUrlQuery;
        } else {
            $urlParts['query'] .= '&' . $returnUrlQuery;
        }

        wp_redirect(http_build_url($urlParts));
    }

    public function paymentSuccess()
    {
        return $this->renderTemplate('payment-success');
    }

    public function paymentError()
    {
        return $this->renderTemplate('payment-error');
    }
}
