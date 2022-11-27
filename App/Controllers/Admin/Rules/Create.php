<?php

/**
 * @package SDWPRM
 */

namespace App\Controllers\Admin\Rules;

use App\Base\Controller;
use App\Base\Helper;

class Create extends Controller
{
    public function post()
    {
        global $wpdb;
        // CSRF Check
        if (!(isset($_POST['form_nonce']) && wp_verify_nonce($_POST['form_nonce'], $this->plugin_slug . 'create_rule'))) {
            _e('Access diened');
            return;
        }
        if (!isset($_POST['uri']) or !isset($_POST['redirect_to']) or !isset($_POST['status'])) {
            _e('Please enter all required inputs.');
            return;
        }
        $uri = trim($_POST['uri']);
        $uri_hash = Helper::hash($uri);
        $redirect_to = $_POST['redirect_to'];
        $status = $_POST['status'] == 1 ? 1 : 0;
        if (mb_strlen($uri, 'UTF-8') == 0 or mb_strlen($uri, 'UTF-8') > 255) {
            _e('Redirect from must be 1 char and under 255 char');
            return;
        }
        if (mb_strlen($redirect_to, 'UTF-8') == 0 or mb_strlen($redirect_to, 'UTF-8') > 255) {
            _e('Redirect to must be 1 char and under 255 char');
            return;
        }
        $rule = $wpdb->get_row("SELECT * FROM `{$this->rules_table_name}` WHERE `uri_hash`='{$uri_hash}' LIMIT 1");
        if ($rule !== null) {
            _e('Redirect rule is duplicate > edit #' . $rule->id);
            return;
        }
        $result = $wpdb->insert(
            $this->rules_table_name,
            [
                'uri' => $uri,
                'uri_hash' => $uri_hash,
                'redirect_to' => $redirect_to,
                'status' => $status,
            ],
            ['%s', '%s', '%s', '%d']
        );
        if ($result) {
            wp_redirect($this->route('rules', ['notice' => 'rule_created_successfully']));
            exit();
        } else {
            _e('Error while adding data.');
            return;
        }
    }

    public function index()
    {
        $this->admin_view('rules.create');
    }
}
