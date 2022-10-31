<?php
/**
 * @package SDWPRM
 */

namespace SDWPRM\Controllers\Admin;

use SDWPRM\Base\Controller;

class Enqueue extends Controller
{
    public function enqueue ()
    {
        wp_enqueue_style (
            $this->plugin_slug . 'style',
            $this->asset_url . 'css/style.css',
            [],
            $this->plugin_version
        );
        wp_enqueue_script (
            $this->plugin_slug . 'script',
            $this->asset_url . 'js/script.js',
            [],
            $this->plugin_version
        );
    }
    public function run()
    {
        add_action ('admin_enqueue_scripts', [$this, 'enqueue']);
    }
}
