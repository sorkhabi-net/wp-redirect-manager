<?php

/**
 * @package SWPRM
 */

namespace SWPRM\Base;

class Activate extends Controller
{
    private function create_table()
    {
        global $wpdb;

        $charset_collate = $wpdb->get_charset_collate();

        // Rules table
        $rules_table_name = $this->rules_table_name;
        $sql = "
            CREATE TABLE `{$rules_table_name}` (
                `id` int NOT NULL AUTO_INCREMENT,
                `uri` varchar(255) COLLATE utf8mb4_bin NOT NULL,
                `redirect_to` varchar(255) COLLATE utf8mb4_bin NOT NULL,
                `http_status_code` int NOT NULL,
                `status` tinyint NOT NULL,
                `view` int NOT NULL,
                PRIMARY KEY (`id`),
                KEY `uri` (`uri`),
                KEY `status` (`status`)
            ) {$charset_collate};
        ";

        // Error 404 table
        $error_404_table_name = $this->error_404_table_name;
        $sql .= "
            CREATE TABLE `{$error_404_table_name}` (
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
    }
    private function default_options()
    {
        return [
            'status' => 1,
            'error_404' => 1,
            'http_status_code' => 301,
        ];
    }
    private function init_options()
    {
        foreach ($this->default_options() as $option_key => $option_value) {
            if ($this->get_setting($option_key) === false) {
                $this->update_setting($option_key, $option_value);
            }
        }
    }
    public function run()
    {
        $this->init_options();
        $this->create_table();
    }
}