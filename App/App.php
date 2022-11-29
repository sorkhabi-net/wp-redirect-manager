<?php
/**
 * @package SDWPRM
 */

namespace App;

use App\Base\Controller;

 final class App 
 {
    public static function get_processes ()
    {
        return [
            Base\AdminMenuPage::class,
            Controllers\Main\Redirector::class,
            Controllers\Main\Error404Tracker::class,
        ];
    }

    public static function instantiate ($class)
    {
        return new $class ();
    }

    public static function run ()
    {
        foreach (self::get_processes() as $class){
            $process = self::instantiate ($class);
            if (method_exists($process, 'run')){
                $process->run ();
            }
        }
    }
 }