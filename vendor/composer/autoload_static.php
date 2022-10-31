<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit52f16a9c898ddec596ff73067eb8c904
{
    public static $prefixLengthsPsr4 = array (
        'S' => 
        array (
            'SDWPRM\\' => 7,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'SDWPRM\\' => 
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
            $loader->prefixLengthsPsr4 = ComposerStaticInit52f16a9c898ddec596ff73067eb8c904::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit52f16a9c898ddec596ff73067eb8c904::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInit52f16a9c898ddec596ff73067eb8c904::$classMap;

        }, null, ClassLoader::class);
    }
}