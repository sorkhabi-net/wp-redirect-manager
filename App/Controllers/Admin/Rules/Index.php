<?php

/**
 * @package SDWPRM
 */

namespace App\Controllers\Admin\Rules;

use App\Base\Controller;

class Index extends Controller
{
    public function index()
    {
        global $wpdb;
        $rules = $wpdb->get_results("SELECT * FROM `{$this->rules_table_name}` ORDER BY `id` DESC LIMIT 10");
        $this->admin_view('rules.index', compact('rules'));
    }
}
