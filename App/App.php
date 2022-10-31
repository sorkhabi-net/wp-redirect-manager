<?php
/**
 * @package SDWPRM
 */

 namespace SDWPRM;

use SDWPRM\Base\Controller;

 final class App 
 {
    public static function get_processes ()
    {
        return [
            Controllers\Admin::class,
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