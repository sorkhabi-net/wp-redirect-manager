<?php

/**
 * @package SDWPRM
 */

namespace App\Controllers\Admin;

use App\Base\Controller;

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
        $inputs = ['status', 'error_404'];
        foreach ($inputs as $input){
            if (!isset ($_POST [$input])){
                $this->jsonify('alert', __('Please enter all required inputs.', 'SDWPRM'));
            }
        }
        $_POST ['status'] = intval ($_POST ['status']);
        $_POST ['error_404'] = intval ($_POST ['error_404']);
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
