<?php

/**
 * @package SDWPRM
 */

namespace App\Controllers;

use App\Apis\SettingsApi;
use App\Base\Controller;
use App\Controllers\Admin\Enqueue;
use App\Controllers\Admin\Dashboard;
use App\Controllers\Admin\Settings;

class Admin extends Controller
{
    private function pages ()
    {
        return [
            [
                'page_title' => __('WP Redirect Manager', 'SDWPRM'),
                'menu_title' => __('Redirect Manager', 'SDWPRM'),
                'capability' => 'manage_options',
                'menu_slug' => $this->plugin_slug . 'dashoard',
                'callback' => [new Dashboard(), 'index'],
                'icon_url' => 'dashicons-randomize',
                'position' => 75,
                'sub_pages' => [
                    [
                        'menu_title' => __('Dashboard', 'SDWPRM'),
                    ],
                    [
                        'page_title' => __('WP Redirect Manager Settings', 'SDWPRM'),
                        'menu_title' => __('Settings', 'SDWPRM'),
                        'capability' => 'manage_options',
                        'menu_slug' => $this->plugin_slug . 'settings',
                        'callback' => [new Settings(), 'index'],
                    ],
                ],
            ],
        ];
    }

    public function settings_link ($links)
    {
        $pages = $this->pages();
        foreach ($pages as $page){
            foreach ($page['sub_pages'] as $sub_page){
                if (isset ($sub_page ['menu_slug'])){
                    $slug = $sub_page['menu_slug'];
                }else{
                    $slug = $page ['menu_slug'];
                }
                $settings_link = '<a href="' . admin_url ('admin.php?page=' . $slug) . '">' . $sub_page ['menu_title'] . '</a>';
                $links[] = $settings_link;
            }
        }
        return $links;
    }

    public function run()
    {
        // Create Admin Pages
        $settings = new SettingsApi();
        $settings->addPages ($this->pages ())->run ();

        // Add settings link in plugin page
        add_filter('plugin_action_links_' . SDWPRM_BASE_FILE , [$this, 'settings_link']);

        // Enable Admin Enqueue
        $admin_enqueue = new Enqueue ();
        $admin_enqueue->run ();
    }
}
