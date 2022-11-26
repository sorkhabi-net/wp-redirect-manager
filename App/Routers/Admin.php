<?php

/**
 * @package SDWPRM
 */

namespace App\Routers;

use App\Base\Controller;
use App\Controllers\Admin\Settings;
use App\Controllers\Admin\Rules\Index as RulesIndex;
use App\Controllers\Admin\Rules\Edit as RulesEdit;
use App\Controllers\Admin\Rules\Create as RulesCreate;
use App\Controllers\Admin\Rules\Delete as RulesDelete;

class Admin extends Controller
{
    public function routes ()
    {
        return [
            $this->plugin_slug . 'rules' => RulesIndex::class,
            $this->plugin_slug . 'settings' => Settings::class,
            'create' => RulesCreate::class,
            'edit' => RulesEdit::class,
            'delete' => RulesDelete::class,
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
        if (!isset ($this->routes()[$slug])){
            $slug = $_GET['page'];
        }
        $class_name = $this->routes()[$slug];
        $process = self::instantiate($class_name);
        if (method_exists($process, 'index')) {
            $process->index();
        }
    }
}
