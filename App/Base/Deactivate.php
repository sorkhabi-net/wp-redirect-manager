<?php

/**
 * @package SDWPRM
 */

namespace App\Base;

class Deactivate extends Controller
{
    public function run()
    {
        $this->update_setting('status', 0);
        $this->update_setting('error_404', 0);
        $this->update_setting('system_status', 0);
    }
}
