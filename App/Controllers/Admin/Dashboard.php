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
        global $wpdb;
        $rules = $wpdb->get_results("SELECT * FROM `{$this->rules_table_name}` ORDER BY `id` DESC LIMIT 3");
        
        $this->admin_view('dashboard', compact('rules'));
    }
}
