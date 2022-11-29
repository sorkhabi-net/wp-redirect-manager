<?php

/**
 * @package SDWPRM
 */

namespace App\Base;

class Deactivate extends Controller
{
    public function run()
    {
        $this->update_setting('status', 1);
        $this->update_setting('error_404', 1);
    }
}
