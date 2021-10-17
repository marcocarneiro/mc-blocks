<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInitbc85d7d52e182a37cebff5f98723df6b
{
    public static $prefixLengthsPsr4 = array (
        'C' => 
        array (
            'Carbon_Fields\\' => 14,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Carbon_Fields\\' => 
        array (
            0 => __DIR__ . '/..' . '/htmlburger/carbon-fields/core',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInitbc85d7d52e182a37cebff5f98723df6b::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInitbc85d7d52e182a37cebff5f98723df6b::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInitbc85d7d52e182a37cebff5f98723df6b::$classMap;

        }, null, ClassLoader::class);
    }
}