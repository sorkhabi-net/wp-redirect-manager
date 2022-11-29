<?php

/**
 * @package SDWPRM
 */

namespace App\Controllers\Main;

use App\Base\Helper;
use App\Base\Controller;

class Redirector extends Controller
{

    public function run()
    {
        global $wpdb;
        if (!$this->get_setting('status')) {
            return;
        }
        $wp_uri = home_url ();
        $uri = $_SERVER ['REQUEST_URI'];

        // Remove http://
        if (mb_substr($wp_uri, 0, 7, 'UTF-8') == 'http://'){
            $wp_uri = mb_substr($wp_uri, 7, null, 'UTF-8');
        }
        // Remove https://
        if (mb_substr($wp_uri, 0, 8, 'UTF-8') == 'https://'){
            $wp_uri = mb_substr($wp_uri, 8, null, 'UTF-8');
        }

        $wp_uri_array = explode ('/', $wp_uri);
        $wp_uri_array_count = count($wp_uri_array);

        if ($wp_uri_array_count == 1){
            $wp_uri = '/';
        }else if ($wp_uri_array_count > 1){
            // Remove domain
            unset ($wp_uri_array [0]);
            $wp_uri = implode ('/', $wp_uri_array);
            // Add slash in start of uri if start of uri have not
            if ($wp_uri ['0'] != '/'){
                $wp_uri = '/' . $wp_uri;
            }
            // Add slash in end of uri if end of uri have not
            if (mb_substr($wp_uri, -1, 1, 'UTF-8') != '/'){
                $wp_uri .= '/';
            }
        }
        // Remove default (wordpress installed folder) from uri
        $wp_uri_len = strlen($wp_uri);
        if (mb_substr ($uri, 0, $wp_uri_len, 'UTF-8') == $wp_uri){
            $uri = mb_substr($uri, $wp_uri_len, null, 'UTF-8');
        }

        $rule = $wpdb->get_row("SELECT * FROM `{$this->rules_table_name}` WHERE `uri`='{$uri}' and `status`='1' LIMIT 1");

        if ($rule !== null){
            // Update view count
            $wpdb->query("UPDATE `{$this->rules_table_name}` SET `view` = `view`+1 WHERE `id`='{$rule->id}' LIMIT 1");
            // Redirect
            $r = 'Location: ' . $rule->redirect_to;
            // TODO: Add Http status code
            header ($r);
            exit;
        }
    }
}
