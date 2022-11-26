<?php

/**
 * @package SDWPRM
 */

namespace App\Controllers\Admin\Rules;

use App\Base\Controller;

class Create extends Controller
{
    public function index()
    {
        $this->admin_view('rules.create');
    }
}
