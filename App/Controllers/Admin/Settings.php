<?php

/**
 * @package SDWPRM
 */

namespace App\Controllers\Admin;

use App\Base\Controller;
use App\Base\Helper;

class Settings extends Controller
{
    public function post ()
    {
        // CSRF Check
        if (!(isset($_POST['form_nonce']) && wp_verify_nonce($_POST['form_nonce'], $this->plugin_slug . 'settings'))) {
            $message = __('Something went wrong. Please refresh page and try again.', 'SDWPRM');
            $url = $this->route('settings');
            $url_text = __('Click here');
            $this->jsonify('nonce', compact('message', 'url', 'url_text'));
        }
        $inputs = ['status', 'error_404', 'http_status_code'];
        foreach ($inputs as $input){
            if (!isset ($_POST [$input])){
                $this->jsonify('alert', __('Please enter all required inputs.', 'SDWPRM'));
            }
        }
        $_POST ['status'] = intval ($_POST ['status']);
        $_POST ['error_404'] = intval ($_POST ['error_404']);
        $_POST ['http_status_code'] = intval ($_POST ['http_status_code']);
        $statusList = Helper::http_status_code();
        unset ($statusList [0]);
        if (in_array ($_POST ['http_status_code'], array_keys($statusList)) === false){
            $this->jsonify('http_status_code_error', __('Default http status code is not valid.', 'SDWPRM'));
        }
        foreach ($inputs as $input){
            $this->update_setting ($input, $_POST [$input]);
        }
        $this->jsonify('success', __('New settings saved successfully.', 'SDWPRM'));
    }
    public function index()
    {
        $this->admin_view('settings');
    }
}
