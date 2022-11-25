<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit355978d872e4a281018a47dfff3fc314
{
    public static $prefixLengthsPsr4 = array (
        'A' => 
        array (
            'App\\' => 4,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'App\\' => 
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
            $loader->prefixLengthsPsr4 = ComposerStaticInit355978d872e4a281018a47dfff3fc314::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit355978d872e4a281018a47dfff3fc314::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInit355978d872e4a281018a47dfff3fc314::$classMap;

        }, null, ClassLoader::class);
    }
}
