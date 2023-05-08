<?php

/**
 * @package SWPRM
 */

/*
Plugin Name: WP Redirect Manager
Plugin URI: https://github.com/sorkhabi-net/wp-redirect-manager/
Description: Wordpress Easy and Powerful redirect manager plugin.
Author: Sorkh Dev "Sorkhabi.NeT"
Author URI: https://sorkhabi.net/
Text Domain: SWPRM
Version: 0.8.0
License: GPLv2 or later
*/

defined('ABSPATH') or die('Access denied!');

define('SWPRM_PLUGIN_VERSION', '0.8.0');
define('SWPRM_BASE_FILE', plugin_basename(__FILE__));

// Autoload
$autoload = dirname(__FILE__) . '/vendor/autoload.php';
if (file_exists($autoload)) {
    require_once $autoload;
}

// Activate Plugin
register_activation_hook(__FILE__, function () {
    if (class_exists('SWPRM\\Base\\Activate')) {
        (new SWPRM\Base\Activate)->run();
    }
});

// Deactivate Plugin
register_deactivation_hook(__FILE__, function () {
    if (class_exists('SWPRM\\Base\\Deactivate')) {
        (new SWPRM\Base\Deactivate)->run();
    }
});

// Initialize Plugin
if (class_exists('SWPRM\\App')) {
    SWPRM\App::run();
}