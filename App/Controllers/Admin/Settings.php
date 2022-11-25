<?php

/**
 * @package SDWPRM
 */

namespace App\Controllers\Admin;

use App\Base\Controller;

class Settings extends Controller
{
    public function index()
    {
        $this->admin_view('settings');
    }
}
