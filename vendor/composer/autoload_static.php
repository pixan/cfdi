<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit103ab55c148292474e2d35758c956a51
{
    public static $prefixLengthsPsr4 = array (
        'P' => 
        array (
            'Pixan\\Cfdi\\' => 11,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Pixan\\Cfdi\\' => 
        array (
            0 => __DIR__ . '/../..' . '/src',
        ),
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit103ab55c148292474e2d35758c956a51::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit103ab55c148292474e2d35758c956a51::$prefixDirsPsr4;

        }, null, ClassLoader::class);
    }
}