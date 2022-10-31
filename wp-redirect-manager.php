<?php
/**
 * @package SD_WPRedirectManager
 */

/*
Plugin Name: WP Redirect Manager
Plugin URI: https://github.com/sorkhabi-net/wp-redirect-manager/
Description: Wordpress Easy and Powerful redirect manager plugin.
Author: Sorkh Dev "Sorkhabi.NeT"
Author URI: https://sorkhabi.net/
Version: 0.0.1
License: GPLv2 or later
*/

defined ('ABSPATH') or die ('Access denied!');

// Autoload
$autoload = dirname (__FILE__) . '/vendor/autoload.php';
if (file_exists ($autoload)){
    require_once $autoload;
}

// Activate Plugin
function activate_sdwprm (){
    if (class_exists('SDWPRM\\Base\\Activate')) {
        SDWPRM\Base\Activate::run();
    }
}
register_activation_hook (__FILE__, 'activate_sdwprm');

// Deactivate Plugin
function deactivate_sdwprm (){
    if (class_exists('SDWPRM\\Base\\Deactivate')) {
        SDWPRM\Base\Deactivate::run();
    }
}
register_deactivation_hook (__FILE__, 'deactivate_sdwprm');

// Initialize Plugin
if (class_exists('SDWPRM\\Init')){
    SDWPRM\Init::run ();
}