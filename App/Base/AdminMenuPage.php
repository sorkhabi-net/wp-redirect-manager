<?php

/**
 * @package SWPRM
 */

namespace SWPRM\Base;

class AdminMenuPage extends Controller
{
    private function pages ()
    {
        global $wpdb;
        if (is_admin () and $this->get_setting('status') !== false){
            $error_count = $wpdb->get_var("SELECT COUNT(*) FROM `{$this->error_404_table_name}`");
        }else{
            $error_count = 0;
        }
        return [
            [
                'page_title' => __('WP Redirect Manager > Rules', 'SWPRM'),
                'menu_title' => __('Redirect Manager', 'SWPRM'),
                'capability' => 'manage_options',
                'menu_slug' => 'rules',
                'icon_url' => 'dashicons-randomize',
                'position' => 75,
                'notification' => $error_count,
                'sub_pages' => [
                    [
                        'menu_title' => __('Redirect rules', 'SWPRM'),
                        'show_in_settings' => true,
                        'notification' => 0,
                    ],
                    [
                        'page_title' => __('Error 404 Tracker', 'SWPRM'),
                        'menu_title' => __('Error 404 Tracker', 'SWPRM'),
                        'capability' => 'manage_options',
                        'menu_slug' => 'error_404',
                        'show_in_settings' => true,
                        'notification' => $error_count,
                    ],
                    [
                        'page_title' => __('WP Redirect Manager Settings', 'SWPRM'),
                        'menu_title' => __('Settings', 'SWPRM'),
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

        // For remove notice from pagination url
        add_filter('paginate_links', function ($link) {
            return filter_input(INPUT_GET, 'notice') ? remove_query_arg('notice', $link): $link;
        });
    }
}
