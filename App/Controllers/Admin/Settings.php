<?php

/**
 * @package SDWPRM
 */

namespace SDWPRM\Controllers\Admin;

use SDWPRM\Base\Controller;

class Settings extends Controller
{
    public function index()
    {
        $this->admin_view('settings');
    }
}
