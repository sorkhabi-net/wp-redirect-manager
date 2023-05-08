<?php

/**
 * @package SWPRM
 */

namespace SWPRM\Controllers\Admin\Rules;

use SWPRM\Base\Controller;

class Index extends Controller
{
    public function index()
    {
        global $wpdb;
        if (isset($_GET['notice']) and $_GET['notice'] == 'status_active') {
            $this->update_setting('status', 1);
        }
        $items_per_page = 10;
        $page = intval ($_GET['cpage'] ?? 1);
        $offset = ($page * $items_per_page) - $items_per_page;

        $query = "SELECT * FROM `{$this->rules_table_name}`";

        $total_query = "SELECT COUNT(1) FROM ({$query}) AS combined_table";
        $total = $wpdb->get_var($total_query);

        $rules = $wpdb->get_results("{$query} ORDER BY `id` DESC LIMIT  {$offset}, {$items_per_page}");
        $this->admin_view('rules.index', compact('rules', 'total', 'page', 'items_per_page'));
    }
}
