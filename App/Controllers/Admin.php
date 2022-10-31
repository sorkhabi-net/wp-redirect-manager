<?php

/**
 * @package SDWPRM
 */

namespace SDWPRM\Controllers;

use SDWPRM\Apis\SettingsApi;
use SDWPRM\Base\Controller;
use SDWPRM\Controllers\Admin\Enqueue;
use SDWPRM\Controllers\Admin\Dashboard;
use SDWPRM\Controllers\Admin\Settings;

class Admin extends Controller
{
    private function pages ()
    {
        return [
            [
                'page_title' => 'WP Redirect Manager',
                'menu_title' => 'Redirect Manager',
                'capability' => 'manage_options',
                'menu_slug' => $this->plugin_slug . 'dashoard',
                'callback' => [new Dashboard(), 'index'],
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
                        'menu_slug' => $this->plugin_slug . 'settings',
                        'callback' => [new Settings(), 'index'],
                    ],
                ],
            ],
        ];
    }

    public function run()
    {
        // Create Admin Pages
        $settings = new SettingsApi();
        $settings->addPages ($this->pages ())->run ();

        // Enable Admin Enqueue
        $admin_enqueue = new Enqueue ();
        $admin_enqueue->run ();
    }
}
