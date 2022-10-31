<?php
/**
 * @package SD_WPRedirectManager
 */

 namespace SDWPRM;

 final class Init 
 {
    public static function get_processes ()
    {
        return [
            Base\Enqueue::class,
            Admin\Init::class,
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