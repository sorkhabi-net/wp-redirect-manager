<?php

/**
 * @package SDWPRM
 */

namespace App\Controllers\Admin\Rules;

use App\Base\Controller;
use App\Base\Helper;
use App\Base\Notice;

class Edit extends Controller
{
    public function post()
    {
        global $wpdb;
        $id = $_GET['id'] ?? 0;
        // CSRF Check
        if (!(isset($_POST['form_nonce']) && wp_verify_nonce($_POST['form_nonce'], $this->plugin_slug . 'edit_rule'))) {
            _e('Access diened');
            return;
        }
        if (!isset($_POST['uri']) or !isset($_POST['redirect_to']) or !isset($_POST['status'])) {
            _e('Please enter all required inputs.');
            return;
        }
        $rule = $wpdb->get_row("SELECT * FROM `{$this->rules_table_name}` WHERE `id`='{$id}' LIMIT 1");
        if ($rule === null) {
            _e('Redirect rule is not exists.');
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
        $other_rule = $wpdb->get_row("SELECT * FROM `{$this->rules_table_name}` WHERE `uri_hash`='{$uri_hash}' and `id`!='{$id}' LIMIT 1");
        if ($other_rule !== null) {
            _e('Redirect rule is duplicate > edit #' . $other_rule->id);
            return;
        }
        echo '<pre>';
        var_dump(
            $this->rules_table_name,
            [
                'uri' => $uri,
                'uri_hash' => $uri_hash,
                'redirect_to' => $redirect_to,
                'status' => $status,
            ],
            [
                'id' => $rule->id,
            ],
            ['%s', '%s', '%s', '%d'],
            ['%d']
        );
        $result = $wpdb->update(
            $this->rules_table_name,
            [
                'uri' => $uri,
                'uri_hash' => $uri_hash,
                'redirect_to' => $redirect_to,
                'status' => $status,
            ],
            [
                'id' => $rule->id,
            ],
            ['%s', '%s', '%s', '%d']
            ,
            ['%d']
        );
        wp_redirect($this->route('rules', ['notice' => 'rule_updated_successfully']));
    }

    public function index()
    {
        global $wpdb;
        $id = $_GET ['id'] ?? 0;
        $rule = $wpdb->get_row("SELECT * FROM `{$this->rules_table_name}` WHERE `id`='{$id}' LIMIT 1");
        if ($rule !== null) {
            $this->admin_view('rules.edit', compact ('rule'));
        }else{
            return Notice::show('rule_is_not_exists');
        }
    }
}
