<?php

/**
 * @package SDWPRM
 */

namespace App\Controllers\Admin;

use App\Base\Controller;

class AddNewRule extends Controller
{
    public function index()
    {
        $this->admin_view('add_new_rule');
    }
}
