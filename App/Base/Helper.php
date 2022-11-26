<?php

/**
 * @package SDWPRM
 */

namespace App\Base;

class Helper
{
    private static function controller ($method)
    {
        return (new Controller())->{$method};
    }
    public static function hash ($data)
    {
        return md5 ($data) . crc32($data);
    }
    public static function route ($route_name, $params = [])
    {
        $page = null;
        $action = null;
        if (stripos($route_name, '.') !== false){
            $route_name = explode ('.', $route_name);
            $page = $route_name [0];
            $action = $route_name [1];
        }else{
            $page = $route_name;
        }
        
        $url = 'admin.php?page=' . self::controller('plugin_slug') . $page;

        if ($action !== null){
            $url .= '&action=' . $action;
        }
        if ($params === null){
            return admin_url($url);
        }else{
            return add_query_arg($params, admin_url ($url));
        }
    }
}
