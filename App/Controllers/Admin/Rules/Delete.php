<?php

/**
 * @package SDWPRM
 */

namespace App\Controllers\Admin\Rules;

use App\Base\Controller;

class Delete extends Controller
{
    public function post (){
        global $wpdb;
        if (isset($_POST['form_nonce']) && wp_verify_nonce($_POST['form_nonce'], $this->plugin_slug . 'delete_rule') && isset($_POST['id'])) {
            $id = intval ($_POST['id']);
            $wpdb->delete ($this->rules_table_name, ['id' => $id]);
            return wp_redirect ($this->route ('rules'));
        }else{
            $this->system_view('errors.access_denied');
        }
    }
}
