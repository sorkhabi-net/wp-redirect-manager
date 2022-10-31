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

$autoload = dirname (__FILE__) . '/vendor/autoload.php';

if (file_exists ($autoload)){
    require_once $autoload;
}