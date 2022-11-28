<?php

/**
 * @package SDWPRM
 */

namespace App\Base;

class Controller
{
    public $plugin_path;
    public $plugin_url;
    public $app_path;
    public $asset_url;
    public $view_path;
    public $admin_view_path;
    public $plugin_slug;
    public $plugin_version;
    public $rules_table_name;

    public function __construct()
    {
        global $wpdb;
        $this->plugin_slug = 'sdwprm_';
        $this->plugin_version = '0.4.5';
        $this->plugin_path = plugin_dir_path(dirname(__FILE__, 2));
        $this->plugin_url = plugin_dir_url(dirname(__FILE__, 2));
        $this->app_path = plugin_dir_path(dirname(__FILE__, 1));
        $this->asset_url = $this->plugin_url . 'assets/';
        $this->view_path = $this->app_path . 'Views/';
        $this->admin_view_path = $this->view_path . 'admin/';
        $this->system_view_path = $this->view_path . 'system/';
        $this->rules_table_name = $wpdb->prefix . $this->plugin_slug . 'rules';
    }
    public function route ($route_name, $params = null)
    {
        return Helper::route ($route_name, $params);
    }
    public function admin_view($view_name, $compacts = null)
    {
        $view_name = str_replace('.', '/', $view_name);
        $view_file = $this->admin_view_path . $view_name . '.php';
        if (is_file($view_file)) {
            if ($compacts != null) {
                foreach ($compacts as $var_name => $var_value) {
                    $$var_name = $var_value;
                }
            }
            require_once $view_file;
        } else {
            echo 'View file is not exists. "' . $view_file . '"';
        }
    }
    public function system_view($view_name, $compacts = null)
    {
        $view_name = str_replace('.', '/', $view_name);
        $view_file = $this->system_view_path . $view_name . '.php';
        if (is_file($view_file)) {
            if ($compacts != null) {
                foreach ($compacts as $var_name => $var_value) {
                    $$var_name = $var_value;
                }
            }
            require_once $view_file;
        } else {
            echo 'View file is not exists. "' . $view_file . '"';
        }
    }
    public function jsonify ($type, $result)
    {
        if ($type == 'redirect'){
            $result = [
                'url' => $result
            ];
        }else if (!is_array ($result)){
            $result = [
                'message' => $result
            ];
        }
        echo json_encode(array_merge ([
            'type' => $type,
        ], $result));
        exit;
    }
}
