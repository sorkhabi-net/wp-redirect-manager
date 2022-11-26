<?php

/**
 * @package SDWPRM
 */

namespace App\Base;

class AdminMenuPage extends Controller
{
    private function pages ()
    {
        return [
            [
                'page_title' => __('WP Redirect Manager > Rules', 'SDWPRM'),
                'menu_title' => __('Redirect Manager', 'SDWPRM'),
                'capability' => 'manage_options',
                'menu_slug' => 'rules',
                'icon_url' => 'dashicons-randomize',
                'position' => 75,
                'sub_pages' => [
                    [
                        'menu_title' => __('Rules', 'SDWPRM'),
                        'show_in_settings' => true,
                    ],
                    [
                        'page_title' => __('WP Redirect Manager Settings', 'SDWPRM'),
                        'menu_title' => __('Settings', 'SDWPRM'),
                        'capability' => 'manage_options',
                        'menu_slug' => 'settings',
                        'show_in_settings' => true,
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
        $admin_enqueue = new AdminEnqueue ();
        $admin_enqueue->run ();
    }
}
