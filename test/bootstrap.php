<?php
/**
 * This makes our life easier when dealing with paths. Everything is relative
 * to the application root now.
 */
chdir(dirname(__DIR__));

include_once 'test/UnitTest.php';

class Bootstrap
{
    public static $app_config = array(
        'modules' => array(
            'MonologZf2'
        ),
        'module_listener_options' => array(
            'config_glob_paths' => array(
                'test/config/{,*.}{global,local}.php',
            ),
            'module_paths' => array()
        )
    );

    /**
     *
     * @var \Zend\Mvc\Application
     */
    public static $app;

    /**
     *
     * @var \Zend\ServiceManager\ServiceManager
     */
    public static $sm;

    public static function init()
    {
        static::initAutoloader();
        static::$app = Zend\Mvc\Application::init(static::$app_config);
        static::$app->getServiceManager()->get('config');
    }

    public static function initAutoloader()
    {
        if (file_exists('vendor/autoload.php')) {
            $loader = include 'vendor/autoload.php';
        }

        if (class_exists('Zend\Loader\AutoloaderFactory')) {
            return;
        }

        $zf2Path = false;

        if (is_dir('vendor/ZF2/library')) {
            $zf2Path = 'vendor/ZF2/library';
        } elseif (getenv('ZF2_PATH')) { // Support for ZF2_PATH environment variable or git submodule
            $zf2Path = getenv('ZF2_PATH');
        } elseif (get_cfg_var('zf2_path')) { // Support for zf2_path directive value
            $zf2Path = get_cfg_var('zf2_path');
        }

        if ($zf2Path) {
            if (isset($loader)) {
                $loader->add('Zend', $zf2Path);
                $loader->add('ZendXml', $zf2Path);
            } else {
                include $zf2Path . '/Zend/Loader/AutoloaderFactory.php';
                Zend\Loader\AutoloaderFactory::factory(array(
                    'Zend\Loader\StandardAutoloader' => array(
                        'autoregister_zf' => true
                    )
                ));
            }
        }

        if (! class_exists('Zend\Loader\AutoloaderFactory')) {
            throw new RuntimeException(
                'Unable to load ZF2. Run `php composer.phar install` or define a ZF2_PATH environment variable.'
            );
        }
    }
}

Bootstrap::init();
