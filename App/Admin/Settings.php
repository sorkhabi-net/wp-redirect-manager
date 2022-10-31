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
        $this->admin_view('settings');
    }
}
