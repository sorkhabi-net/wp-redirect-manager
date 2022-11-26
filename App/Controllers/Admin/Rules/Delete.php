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
        // CSRF Check
        if (isset($_POST['form_nonce']) && wp_verify_nonce($_POST['form_nonce'], $this->plugin_slug . 'delete_rule') && isset($_POST['id'])) {
            $id = intval ($_POST['id']);
            $result = $wpdb->delete ($this->rules_table_name, ['id' => $id]);
            if ($result){
                return wp_redirect ($this->route ('rules', ['notice' => 'rule_deleted_successfully']));
            }else{
                return wp_redirect ($this->route ('rules', ['notice' => 'try_again']));
            }
        }else{
            return wp_redirect ($this->route ('rules', ['notice' => 'try_again']));
        }
    }
}
