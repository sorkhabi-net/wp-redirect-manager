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
        
        // Rules table
        $rules_table_name = $this->rules_table_name;
        $sql = "
            CREATE TABLE IF NOT EXISTS `{$rules_table_name}` (
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

        // Error 404 table
        $error_404_table_name = $this->error_404_table_name;
        $sql .= "
            CREATE TABLE IF NOT EXISTS `{$error_404_table_name}` (
            `id` int NOT NULL AUTO_INCREMENT,
            `uri` varchar(255) COLLATE utf8mb4_bin NOT NULL,
            `uri_hash` varchar(42) COLLATE utf8mb4_bin NOT NULL,
            `view` int NOT NULL,
            `last_view_at` DATETIME NOT NULL,
            PRIMARY KEY (`id`),
            UNIQUE KEY `uri_hash` (`uri_hash`),
            KEY `last_view_at` (`last_view_at`)
            ) {$charset_collate};
        ";


        require_once ABSPATH . 'wp-admin/includes/upgrade.php';
        dbDelta($sql);
        $this->update_setting('status', 1);
        $this->update_setting('error_404', 1);
    }
    public function run()
    {
        $this->create_table();
    }
}