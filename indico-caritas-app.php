<?php
/*
Plugin Name: Aplikacja Caritas
Plugin URI: https://aplikacjacaritas.pl
Description: Ta wtyczka dodaje funkcjonalności Aplikacji Caritas do strony internetowej.
Author: Indico Plus | biuro@indicoplus.pl
Author URI: https://indicoplus.pl
Text Domain: caritas-app
Version: 1.4.3
 */
use \IndicoPlus\CaritasApp\Core\Plugin;
defined('ABSPATH') or die('No script kiddies please!');

global $wp_version;

if (version_compare($wp_version, "5.0", "<")) {
    exit(__("Wtyczka Aplikacja Caritas wymaga WordPressa w wersji co najmniej 5.0", 'caritas-app'));
}

if (version_compare(PHP_VERSION, "7.1", "<")) {
    exit(__("Wtyczka Aplikacja Caritas wymaga PHP w wersji co najmniej 7.1", 'caritas-app'));
}

require_once 'vendor/autoload.php';
require_once 'functions.php';

Plugin::instance();
