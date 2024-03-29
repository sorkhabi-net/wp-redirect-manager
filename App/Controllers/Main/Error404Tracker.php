<?php

/**
 * @package SWPRM
 */

namespace SWPRM\Controllers\Main;

use SWPRM\Base\Helper;
use SWPRM\Base\Controller;

class Error404Tracker extends Controller
{

    public function handle()
    {
        global $wpdb;
        if (!is_404()) {
            return;
        }
        $wp_uri = home_url();
        $uri = $_SERVER['REQUEST_URI'];

        // Remove http://
        if (mb_substr($wp_uri, 0, 7, 'UTF-8') == 'http://') {
            $wp_uri = mb_substr($wp_uri, 7, null, 'UTF-8');
        }
        // Remove https://
        if (mb_substr($wp_uri, 0, 8, 'UTF-8') == 'https://') {
            $wp_uri = mb_substr($wp_uri, 8, null, 'UTF-8');
        }

        $wp_uri_array = explode('/', $wp_uri);
        $wp_uri_array_count = count($wp_uri_array);

        if ($wp_uri_array_count == 1) {
            $wp_uri = '/';
        } else if ($wp_uri_array_count > 1) {
            // Remove domain
            unset($wp_uri_array[0]);
            $wp_uri = implode('/', $wp_uri_array);
            // Add slash in start of uri if start of uri have not
            if ($wp_uri['0'] != '/') {
                $wp_uri = '/' . $wp_uri;
            }
            // Add slash in end of uri if end of uri have not
            if (mb_substr($wp_uri, -1, 1, 'UTF-8') != '/') {
                $wp_uri .= '/';
            }
        }
        // Remove default (wordpress installed folder) from uri
        $wp_uri_len = strlen($wp_uri);
        if (mb_substr($uri, 0, $wp_uri_len, 'UTF-8') == $wp_uri) {
            $uri = mb_substr($uri, $wp_uri_len, null, 'UTF-8');
        }

        $uri = urldecode($uri);


        $uri_hash = Helper::hash($uri);

        $error = $wpdb->get_row("SELECT * FROM `{$this->error_404_table_name}` WHERE `uri_hash`='{$uri_hash}' LIMIT 1");

        $now = wp_date('Y-m-d H:i:s');
        if ($error === null) {
            $result = $wpdb->insert(
                $this->error_404_table_name,
                [
                    'uri' => $uri,
                    'uri_hash' => $uri_hash,
                    'view' => 1,
                    'last_view_at' => $now,
                ],
                ['%s', '%s', '%d', '%s']
            );
        } else {
            // Update view count
            $wpdb->query("UPDATE `{$this->error_404_table_name}` SET `view` = `view`+1, `last_view_at`='{$now}' WHERE `id`='{$error->id}' LIMIT 1");
        }
    }
    public function run()
    {
        if ($this->get_setting('error_404')){
            add_action('template_redirect', [$this, 'handle']);
        }
    }
}