<?php
/*
Plugin Name: Aplikacja Caritas
Plugin URI: https://aplikacjacaritas.pl
Description: Ta wtyczka dodaje funkcjonalności Aplikacji Caritas do strony internetowej.
Author: Indico Plus | biuro@indicoplus.pl
Author URI: https://aplikacjacaritas.pl
Text Domain: caritas-app
Version: 0.0.1
 */
defined('ABSPATH') or die('No script kiddies please!');

global $wp_version;
$plugin_path = plugin_dir_path(__FILE__);

if (version_compare($wp_version, "5.0", "<")) {
    exit(__("Wtyczka Aplikacja Caritas wymaga WordPressa w wersji co najmniej 5.0", 'caritas-app'));
}

require_once 'autoload.php';

if (!function_exists('caritas_app_get_formatted_price')) {
    function caritas_app_get_formatted_price(int $price)
    {
        return CaritasApp\Core\Helper::getFormattedPrice($price);
    }
}
if (!function_exists('caritas_app_parse_formatted_price')) {
    function caritas_app_parse_formatted_price(int $price)
    {
        return CaritasApp\Core\Helper::parseFormattedPrice($price);
    }
}

global $caritas_app_plugin;
$caritas_app_plugin = new CaritasApp\Core\Plugin($plugin_path);
