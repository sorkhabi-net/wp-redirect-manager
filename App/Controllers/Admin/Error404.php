<?php

/**
 * @package SWPRM
 */

namespace SWPRM\Controllers\Admin;

use SWPRM\Base\Controller;

class Error404 extends Controller
{
    public function index()
    {
        global $wpdb;
        if (isset($_GET['notice']) and $_GET['notice'] == 'error_404_tracker_active') {
            $this->update_setting('error_404', 1);
        }
        $items_per_page = 10;
        $page = intval($_GET['cpage'] ?? 1);
        $offset = ($page * $items_per_page) - $items_per_page;

        $query = "SELECT * FROM `{$this->error_404_table_name}`";

        $total_query = "SELECT COUNT(1) FROM ({$query}) AS combined_table";
        $total = $wpdb->get_var($total_query);

        $errors = $wpdb->get_results("{$query} ORDER BY `last_view_at` DESC LIMIT  {$offset}, {$items_per_page}");
        $this->admin_view('error_404', compact('errors', 'total', 'page', 'items_per_page'));
    }
}
