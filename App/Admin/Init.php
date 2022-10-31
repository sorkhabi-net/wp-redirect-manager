<?php

/**
 * @package SD_WPRedirectManager
 */

namespace SDWPRM\Admin;

use SDWPRM\Api\SettingsApi;
use SDWPRM\Controller;

class Init extends Controller
{
    public $settings;
    public $pages = [];

    public function __construct()
    {
        $this->settings = new SettingsApi();

        $this->pages = [
            [
                'page_title' => 'WP Redirect Manager',
                'menu_title' => 'Redirect Manager',
                'capability' => 'manage_options',
                'menu_slug' => 'sd_wp_redirect_manager',
                'callback' => [new Dashboard() , 'index'],
                'icon_url' => 'dashicons-randomize',
                'position' => 1,
                'sub_pages' => [
                    [
                        'menu_title' => 'Dashboard',
                    ],
                    [
                        'page_title' => 'WP Redirect Manager Settings',
                        'menu_title' => 'Settings',
                        'capability' => 'manage_options',
                        'menu_slug' => 'sd_wp_redirect_manager_settings',
                        'callback' => [new Settings (), 'index'],
                    ],
                ],
            ],
        ];
    }

    public function run()
    {
        $this->settings->addPages ($this->pages)->run ();
    }
}
