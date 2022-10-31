<?php
/**
 * @package SD_WPRedirectManager
 */

namespace SDWPRM;

class Controller
{
    public $plugin_path;
    public $plugin_url;
    public $asset_url;

    public function __construct()
    {
        $this->plugin_path = plugin_dir_path (dirname (__FILE__, 1));
        $this->plugin_url = plugin_dir_url (dirname (__FILE__, 1));
        $this->asset_url = $this->plugin_url . 'asset/';
    }
}
