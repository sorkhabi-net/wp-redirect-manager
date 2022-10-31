<?php

/**
 * @package SD_WPRedirectManager
 */

namespace SDWPRM\Admin;

use SDWPRM\Api\SettingsApi;
use SDWPRM\Controller;

class Dashboard extends Controller
{
    public function index ()
    {
        $date = date ('Y-m-d H:i:s');
        $this->admin_view ('dashboard', compact ('date'));
    }
}
