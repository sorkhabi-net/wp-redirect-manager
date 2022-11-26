<?php

/**
 * @package SDWPRM
 */

namespace App\Apis;
use App\Base\Controller;

class SettingsApi extends controller
{
    public $admin_pages = [];

    public function AddPages (array $pages)
    {
        $this->admin_pages = $pages;

        return $this;
    }

    public function add_admin_menu ()
    {
        foreach ($this->admin_pages as $page){
            add_menu_page(
                $page ['page_title'],
                $page ['menu_title'],
                $page ['capability'],
                $this->plugin_slug . $page ['menu_slug'],
                $page ['callback'],
                $page ['icon_url'],
                $page ['position']
            );
            if (isset ($page['sub_pages']) and count ($page ['sub_pages']) > 0){
                $this->add_admin_sub_menu ($page);
            }
        }
    }

    public function add_admin_sub_menu ($page)
    {
        foreach ($page ['sub_pages'] as $sub_page){
            $parent_slug = $this->plugin_slug . $page['menu_slug'];
            if (count ($sub_page) == 1 or count($sub_page) == 2){
                $sub_menu = $page;
                $sub_menu ['menu_title'] = $sub_page ['menu_title'];
                $sub_menu ['callback'] = null;
            }else{
                $sub_menu = $sub_page;
                if (isset ($sub_page ['show_in_menu']) and $sub_page ['show_in_menu'] == false){
                    $parent_slug = null;
                }
            }
            add_submenu_page(
                $parent_slug,
                $sub_menu['page_title'],
                $sub_menu['menu_title'],
                $sub_menu['capability'],
                $this->plugin_slug . $sub_menu['menu_slug'],
                $sub_menu['callback']
            );
        }
    }

    public function settings_link ($links)
    {
        $pages = $this->admin_pages;
        foreach ($pages as $page) {
            foreach ($page['sub_pages'] as $sub_page) {
                if ($sub_page['show_in_settings']) {
                    if (isset($sub_page['menu_slug'])) {
                        $slug = $sub_page['menu_slug'];
                    } else {
                        $slug = $page['menu_slug'];
                    }
                    $slug = $this->plugin_slug . $slug;
                    $settings_link = '<a href="' . admin_url('admin.php?page=' . $slug) . '">' . $sub_page['menu_title'] . '</a>';
                    $links[] = $settings_link;
                }
            }
        }
        return $links;
    }

    public function run()
    {
        if (count ($this->admin_pages) > 0){
            add_action ('admin_menu', [$this, 'add_admin_menu']);
            // Add settings link in plugin page
            add_filter('plugin_action_links_' . SDWPRM_BASE_FILE, [$this, 'settings_link']);
        }
        
    }
}
