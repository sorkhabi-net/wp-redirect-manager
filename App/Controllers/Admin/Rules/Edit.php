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
            $message = __('Something went wrong. Please refresh page and try again.', 'SDWPRM');
            $url = $this->route('rules.edit', ['id' => $id]);
            $url_text = __('Click here');
            $this->jsonify('nonce', compact('message', 'url', 'url_text'));
        }
        if (!isset($_POST['uri']) or !isset($_POST['redirect_to']) or !isset($_POST['status'])) {
            $this->jsonify('alert', __('Please enter all required inputs.', 'SDWPRM'));
        }
        $rule = $wpdb->get_row("SELECT * FROM `{$this->rules_table_name}` WHERE `id`='{$id}' LIMIT 1");
        if ($rule === null) {
            $this->jsonify('alert', __('Redirect rule is not exists.', 'SDWPRM'));
        }
        $uri = trim($_POST['uri']);
        $uri_hash = Helper::hash($uri);
        $redirect_to = trim($_POST['redirect_to']);
        $status = $_POST['status'] == 1 ? 1 : 0;
        if (mb_strlen($uri, 'UTF-8') == 0 or mb_strlen($uri, 'UTF-8') > 255) {
            $this->jsonify('uri_len', __('Redirect from must be 1 char and under 255 char', 'SDWPRM'));
        }
        if (mb_strlen($redirect_to, 'UTF-8') == 0 or mb_strlen($redirect_to, 'UTF-8') > 255) {
            $this->jsonify('redirect_to_len', __('Redirect to must be 1 char and under 255 char', 'SDWPRM'));
        }
        $other_rule = $wpdb->get_row("SELECT * FROM `{$this->rules_table_name}` WHERE `uri_hash`='{$uri_hash}' and `id`!='{$id}' LIMIT 1");
        if ($other_rule !== null) {
            $message = __('Redirect rule is duplicate you can edit old rule.', 'SDWPRM');
            $url = $this->route('rules.edit', ['id' => $rule->id]);
            $url_text = __('Click here');
            $this->jsonify('duplicate', compact('message', 'url', 'url_text'));
        }
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
            ['%s', '%s', '%s', '%d'],
            ['%d']
        );
        if (isset($_GET['error_404'])) {
            $error_id = intval($_GET['error_404']);
            $wpdb->delete($this->error_404_table_name, ['id' => $error_id]);
        }
        $url = $this->route('rules', ['notice' => 'rule_updated_successfully']);
        $this->jsonify('redirect', $url);
    }

    public function index()
    {
        global $wpdb;
        $id = $_GET['id'] ?? 0;
        $error_id = isset($_GET['error_404']) ? intval($_GET['error_404']) : 0;
        $rule = $wpdb->get_row("SELECT * FROM `{$this->rules_table_name}` WHERE `id`='{$id}' LIMIT 1");
        if ($rule !== null) {
            $this->admin_view('rules.edit', compact('rule', 'error_id'));
        } else {
            return Notice::show('rule_is_not_exists');
        }
    }
}
