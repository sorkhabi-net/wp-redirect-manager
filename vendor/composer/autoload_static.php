<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInitfd40500d4f4c10f49b48c6735d2dab4b
{
    public static $prefixLengthsPsr4 = array (
        'S' => 
        array (
            'SWPRM\\' => 6,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'SWPRM\\' => 
        array (
            0 => __DIR__ . '/../..' . '/App',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInitfd40500d4f4c10f49b48c6735d2dab4b::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInitfd40500d4f4c10f49b48c6735d2dab4b::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInitfd40500d4f4c10f49b48c6735d2dab4b::$classMap;

        }, null, ClassLoader::class);
    }
}
