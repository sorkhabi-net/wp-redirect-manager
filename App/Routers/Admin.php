<?php

/**
 * @package SDWPRM
 */

namespace App\Routers;

use App\Base\Controller;
use App\Controllers\Admin\Dashboard;
use App\Controllers\Admin\Settings;
use App\Controllers\Admin\AddNewRule;

class Admin extends Controller
{
    public function routes ()
    {
        return [
            $this->plugin_slug . 'rules' => Dashboard::class,
            $this->plugin_slug . 'settings' => Settings::class,
            'add_new_rule' => AddNewRule::class,
        ];
    }

    public static function instantiate($class)
    {
        return new $class();
    }

    public function run()
    {
        if (isset ($_GET ['action'])){
            $slug = $_GET['action'];
        }else{
            $slug = $_GET['page'];
        }
        if (isset ($this->routes()[$slug])){
            $process = self::instantiate($this->routes()[$slug]);
            if (method_exists($process, 'index')) {
                $process->index();
            }
        }
    }
}
