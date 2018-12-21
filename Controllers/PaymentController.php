<?php

namespace CaritasApp\Controllers;

use CaritasApp\Controllers\Controller;

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

        wp_redirect($res->url);
    }
}
