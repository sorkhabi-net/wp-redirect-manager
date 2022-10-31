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
                'callback' => function () { echo '<h1>Salam :)</h1>'; },
                'icon_url' => 'dashicons-store',
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
                        'callback' => function () { echo '<h1>Settings :)</h1>'; },
                        'position' => 1.5,
                    ],
                    [
                        'page_title' => 'WP Redirect Manager 404',
                        'menu_title' => '404',
                        'capability' => 'manage_options',
                        'menu_slug' => 'sd_wp_redirect_manager_404',
                        'callback' => function () { echo '<h1>404! :)</h1>'; },
                        'position' => 1.3,
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
