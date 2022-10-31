<?php
/**
 * @package SD_WPRedirectManager
 */

namespace SDWPRM\Base;

use SDWPRM\Controller;

class Enqueue extends Controller
{
    public function enqueue ()
    {
        wp_enqueue_style ('sdwprm_style', $this->asset_url . 'css/style.css');
        wp_enqueue_script ('sdwprm_script', $this->asset_url . 'js/script.js');
    }
    public function run()
    {
        add_action ('admin_enqueue_scripts', [$this, 'enqueue']);
    }
}
