<?php

/**
 * @package SDWPRM
 */

namespace App\Controllers\Admin;

use App\Base\Controller;

class Dashboard extends Controller
{
    public function index()
    {
        $date = date('Y-m-d H:i:s');
        $this->admin_view('dashboard', compact('date'));
    }
}
