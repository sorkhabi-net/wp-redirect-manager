<?php

/**
 * @package SDWPRM
 */

namespace App\Controllers\Admin\Rules;

use App\Base\Controller;

class Edit extends Controller
{
    public function index()
    {
        $id = $_GET ['id'] ?? 0;
        $this->admin_view('rules.edit', compact ('id'));
    }
}
