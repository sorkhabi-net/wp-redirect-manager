<?php

/**
 * @package SDWPRM
 */

namespace App\Controllers\Admin\Rules;

use App\Base\Controller;

class Delete extends Controller
{
    public function index()
    {
        $id = $_GET ['id'] ?? 0;
        echo 'Deleted';
        wp_safe_redirect('/');
        exit ();
        $this->admin_view('rules.edit', compact ('id'));
    }
}
