<?php

/**
 * @package SDWPRM
 */

namespace App\Apis;

class SettingsApi
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
                $page ['menu_slug'],
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
            if (count ($sub_page) == 1){
                $sub_menu = $page;
                $sub_menu ['menu_title'] = $sub_page ['menu_title'];
                $sub_menu ['callback'] = null;
            }else{
                $sub_menu = $sub_page;
            }
            add_submenu_page(
                $page['menu_slug'],
                $sub_menu['page_title'],
                $sub_menu['menu_title'],
                $sub_menu['capability'],
                $sub_menu['menu_slug'],
                $sub_menu['callback']
            );
        }
    }

    public function run()
    {
        if (count ($this->admin_pages) > 0){
            add_action ('admin_menu', [$this, 'add_admin_menu']);
        }
    }
}
