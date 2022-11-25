<?php
/**
 * @package SDWPRM
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
register_activation_hook (__FILE__, function (){
    if (class_exists('App\\Base\\Activate')) {
        App\Base\Activate::run();
    }
});

// Deactivate Plugin
register_deactivation_hook (__FILE__, function (){
    if (class_exists('App\\Base\\Deactivate')) {
        App\Base\Deactivate::run();
    }
});

// Initialize Plugin
if (class_exists('App\\App')){
    App\App::run ();
}