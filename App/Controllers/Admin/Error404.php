<?php

/**
 * @package SDWPRM
 */

namespace App\Controllers\Admin;

use App\Base\Controller;

class Error404 extends Controller
{
    public function index()
    {
        $this->admin_view('error_404');
    }
}
