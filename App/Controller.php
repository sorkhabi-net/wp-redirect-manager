<?php
/**
 * @package SD_WPRedirectManager
 */

namespace SDWPRM;

class Controller
{
    public $plugin_path;
    public $plugin_url;
    public $app_path;
    public $asset_url;
    public $view_path;
    public $admin_view_path;

    public function __construct()
    {
        $this->plugin_path = plugin_dir_path (dirname (__FILE__, 1));
        $this->plugin_url = plugin_dir_url (dirname (__FILE__, 1));
        $this->app_path = plugin_dir_path (__FILE__);
        $this->asset_url = $this->plugin_url . 'asset/';
        $this->view_path = $this->app_path . 'Views/';
        $this->admin_view_path = $this->view_path . 'Admin/';
    }
}
