<?php

/**
 * @package SWPRM
 */

namespace SWPRM\Controllers\Admin\Rules;

use SWPRM\Base\Controller;
use SWPRM\Base\Helper;

class Create extends Controller
{
    public function post()
    {
        global $wpdb;
        // CSRF Check
        if (!(isset($_POST['form_nonce']) && wp_verify_nonce($_POST['form_nonce'], $this->plugin_slug . 'create_rule'))) {
            $message = __('Something went wrong. Please refresh page and try again.', 'SWPRM');
            $url = $this->route ('rules.create');
            $url_text = __('Click here');
            $this->jsonify('nonce', compact ('message', 'url', 'url_text'));
        }
        if (!isset($_POST['uri']) or !isset($_POST['redirect_to']) or !isset($_POST['status']) or !isset ($_POST ['http_status_code'])) {
            $this->jsonify('alert', __('Please enter all required inputs.', 'SWPRM'));
        }
        $uri = trim($_POST['uri']);
        if (mb_strlen($uri, 'UTF-8') != 1 and mb_substr ($uri, 0, 1, 'UTF-8') == '/'){
            $uri = mb_substr($uri, 1, null, 'UTF-8');
        }
        $redirect_to = trim ($_POST['redirect_to']);
        $status = $_POST['status'] == 1 ? 1 : 0;
        $http_status_code = intval ($_POST ['http_status_code']);
        $statusList = Helper::http_status_code();
        if (in_array($_POST['http_status_code'], array_keys($statusList)) === false) {
            $this->jsonify('http_status_code_error', __('http status code is not valid.', 'SWPRM'));
        }
        if (mb_strlen($uri, 'UTF-8') == 0 or mb_strlen($uri, 'UTF-8') > 255) {
            $this->jsonify('uri_len', __('Redirect from must be 1 char and under 255 char', 'SWPRM'));
        }
        if (mb_strlen($redirect_to, 'UTF-8') == 0 or mb_strlen($redirect_to, 'UTF-8') > 255) {
            $this->jsonify('redirect_to_len', __('Redirect to must be 1 char and under 255 char', 'SWPRM'));
        }
        $error_id = isset($_GET['error_404']) ? intval($_GET['error_404']) : 0;
        $rule = $wpdb->get_row("SELECT * FROM `{$this->rules_table_name}` WHERE `uri`='{$uri}' LIMIT 1");
        if ($rule !== null) {
            $message = __('Redirect rule is duplicate you can edit old rule.', 'SWPRM');
            $url = $this->route ('rules.edit', ['id' => $rule->id, 'error_404' => $error_id]);
            $url_text = __('Click here');
            $this->jsonify('duplicate', compact ('message', 'url', 'url_text'));
        }
        $result = $wpdb->insert(
            $this->rules_table_name,
            [
                'uri' => $uri,
                'redirect_to' => $redirect_to,
                'http_status_code' => $http_status_code,
                'status' => $status,
            ],
            ['%s','%s', '%d', '%d']
        );
        if ($result) {
            if ($error_id > 0){
                $result = $wpdb->delete($this->error_404_table_name, ['id' => $error_id]);
            }
            $url = $this->route('rules', ['notice' => 'rule_created_successfully']);
            $this->jsonify('redirect', $url);
        } else {
            $this->jsonify('alert', __('Error while adding data.', 'SWPRM'));
        }
    }

    public function index()
    {
        global $wpdb;
        $uri = '';
        $error_id = 0;
        if (isset ($_GET ['error_404'])){
            $error_id = intval ($_GET ['error_404']);
            $error = $wpdb->get_row("SELECT * FROM `{$this->error_404_table_name}` WHERE `id`='{$error_id}' LIMIT 1");
            if ($error !== null) {
                $uri = $error->uri;
            }
        }
        $this->admin_view('rules.create', compact ('error_id', 'uri'));
    }
}
