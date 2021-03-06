<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit66f6870944062934db6b4ee0800dd4a6
{
    public static $prefixLengthsPsr4 = array (
        'R' => 
        array (
            'Read175\\HtmlCrafter\\' => 20,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Read175\\HtmlCrafter\\' => 
        array (
            0 => __DIR__ . '/../..' . '/src',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit66f6870944062934db6b4ee0800dd4a6::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit66f6870944062934db6b4ee0800dd4a6::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInit66f6870944062934db6b4ee0800dd4a6::$classMap;

        }, null, ClassLoader::class);
    }
}
