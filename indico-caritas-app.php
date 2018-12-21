<?php
/*
Plugin Name: Indico+Caritas
Plugin URI: https://aplikacjacaritas.pl
Description: Ta wtyczka dodaje funkcjonalności Aplikacji Caritas do strony internetowej.
Author: Indico Plus | biuro@indicoplus.pl
Author URI: https://aplikacjacaritas.pl
Text Domain: caritas-app
Version: 1.0
 */
defined('ABSPATH') or die('No script kiddies please!');

global $wp_version;
$plugin_path = plugin_dir_path(__FILE__);

if (version_compare($wp_version, "5.0", "<")) {
    exit(__("Wtyczka Aplikacja Caritas wymaga WordPressa w wersji co najmniej 5.0", 'caritas-app'));
}

require_once 'autoload.php';
require_once 'functions.php';

global $caritas_app_plugin;
$caritas_app_plugin = new CaritasApp\Core\Plugin($plugin_path);

register_activation_hook(__FILE__, [$caritas_app_plugin, 'handleActivation']);
