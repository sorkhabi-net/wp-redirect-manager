<?php

/**
 * @package SDWPRM
 */

namespace App\Base;

class Activate extends Controller
{
    public function create_table()
    {
        global $wpdb;

        $charset_collate = $wpdb->get_charset_collate();
        $table_name = $this->rules_table_name;


        $sql = "
            CREATE TABLE IF NOT EXISTS `{$table_name}` (
            `id` int NOT NULL AUTO_INCREMENT,
            `uri` varchar(255) COLLATE utf8mb4_bin NOT NULL,
            `uri_hash` varchar(42) COLLATE utf8mb4_bin NOT NULL,
            `redirect_to` varchar(255) COLLATE utf8mb4_bin NOT NULL,
            `status` tinyint NOT NULL,
            `view` int NOT NULL,
            PRIMARY KEY (`id`),
            KEY `uri_hash` (`uri_hash`),
            KEY `status` (`status`)
            ) {$charset_collate};
        ";


        require_once ABSPATH . 'wp-admin/includes/upgrade.php';
        dbDelta($sql);

        update_option($this->plugin_slug . 'status', 1);
    }
    public function run()
    {
        $this->create_table();
    }
}