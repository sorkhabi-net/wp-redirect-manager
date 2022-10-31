<?php

/**
 * @package SD_WPRedirectManager
 */

namespace SDWPRM\Admin;

use SDWPRM\Api\SettingsApi;
use SDWPRM\Controller;

class Settings extends Controller
{
    public function index ()
    {
        require_once $this->admin_view_path . 'settings.php';
    }
}
