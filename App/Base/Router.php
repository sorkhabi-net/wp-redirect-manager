<?php

/**
 * @package SDWPRM
 */

namespace App\Base;

use App\Base\Controller;
use App\Routers\Admin;

class Router extends Controller
{

    public $routes = [];
    public $routers = [];

    public function routers ()
    {
        return [
            Admin::class,
        ];
    }
    
    public function run_routers ()
    {
        foreach ($this->routers () as $router){
            $router = self::instantiate ($router);
            $this->routes = array_merge ($this->routes, $router->routes ());
        }
    }
    public static function instantiate($class)
    {
        return new $class();
    }

    public function run()
    {
        $this->run_routers ();
        $page = str_replace ($this->plugin_slug, '', $_GET['page']);
        if (isset ($this->routes [$page])){
            $routes = $this->routes [$page];
            $action = isset ($_GET ['action']) ? $_GET ['action'] : 'index';

            $route = null;

            foreach ($routes as $r){
                if ($r ['action'] == $action){
                    $route = $r;
                    break;
                }
            }

            if ($route !== null){
                $class = self::instantiate($route ['class']);
                if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                    $request_method = 'post';
                    $class_method = 'post';
                }else{
                    $request_method = 'get';
                    $class_method = 'index';
                }

                if (in_array ($request_method, $route ['methods']) and method_exists($class, $class_method)) {
                    $class->$class_method();
                }else{
                    $this->system_view('errors.access_denied');
                }
            }else{
                $this->system_view('errors.access_denied');
            }
        }
    }
}
