<?php

/**
 * @package SDWPRM
 */

namespace App\Base;

class Deactivate extends Controller
{
    public function run()
    {
        update_option($this->plugin_slug . 'status', 0);
    }
}
