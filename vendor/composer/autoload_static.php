<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInitaad07c3dafb92051c90b3c36e43d48a2
{
    public static $prefixLengthsPsr4 = array (
        'G' => 
        array (
            'Geodistance\\' => 12,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Geodistance\\' => 
        array (
            0 => __DIR__ . '/..' . '/0x13a/geodistance-php/src',
        ),
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInitaad07c3dafb92051c90b3c36e43d48a2::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInitaad07c3dafb92051c90b3c36e43d48a2::$prefixDirsPsr4;

        }, null, ClassLoader::class);
    }
}
