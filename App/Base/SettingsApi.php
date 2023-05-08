<?php

/**
 * @package SWPRM
 */

namespace SWPRM\Base;

use SWPRM\Base\Controller;

class SettingsApi extends controller
{
    public $admin_pages = [];

    public function AddPages(array $pages)
    {
        $this->admin_pages = $pages;

        return $this;
    }

    public function add_admin_menu()
    {
        foreach ($this->admin_pages as $page) {
            $callback = [new Router(), 'run'];
            if (isset ($page ['notification']) and $page ['notification'] > 0){
                $page['menu_title'] = $page['menu_title'] . ' <span class="awaiting-mod">' . $page ['notification'] . '</span>';
            }
            $hook = add_menu_page(
                $page['page_title'],
                $page['menu_title'],
                $page['capability'],
                $this->plugin_slug . $page['menu_slug'],
                $callback,
                $page['icon_url'],
                $page['position']
            );
            $this->request_callback_handler($hook, $callback);
            if (isset($page['sub_pages']) and count($page['sub_pages']) > 0) {
                $this->add_admin_sub_menu($page);
            }
        }
    }

    public function add_admin_sub_menu($page)
    {
        foreach ($page['sub_pages'] as $sub_page) {
            $parent_slug = $this->plugin_slug . $page['menu_slug'];
            if (count($sub_page) <= 3) {
                if (isset ($sub_page['notification']) and $sub_page['notification'] == 0){
                    $sub_menu = $page;
                    $sub_menu ['notification'] = 0;
                }else{
                    $sub_menu = $page;
                }
                $sub_menu['menu_title'] = $sub_page['menu_title'];
                $callback = null;
            } else {
                $sub_menu = $sub_page;
                if (isset($sub_page['show_in_menu']) and $sub_page['show_in_menu'] == false) {
                    $parent_slug = null;
                }
                $callback = [new Router(), 'run'];
            }
            if (isset($sub_menu ['notification']) and $sub_menu ['notification'] > 0) {
                $sub_menu ['menu_title'] = $sub_menu ['menu_title'] . ' <span class="awaiting-mod">' . $sub_menu['notification'] . '</span>';
            }
            $hook = add_submenu_page(
                $parent_slug,
                $sub_menu['page_title'],
                $sub_menu['menu_title'],
                $sub_menu['capability'],
                $this->plugin_slug . $sub_menu['menu_slug'],
                $callback
            );
            $this->request_callback_handler($hook, $callback);
        }
    }

    public function request_callback_handler($hook, $callback)
    {
        add_action('load-' . $hook, function () use ($callback) {
            if ($callback !== null) {
                if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                    $class = new $callback[0]();
                    $class->{$callback[1]}();
                    exit();
                }
            }
        });
    }

    public function settings_link($links)
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
        if (count($this->admin_pages) > 0) {
            add_action('admin_menu', [$this, 'add_admin_menu']);
            // Add settings link in plugin page
            add_filter('plugin_action_links_' . SWPRM_BASE_FILE, [$this, 'settings_link']);
        }
    }
}
