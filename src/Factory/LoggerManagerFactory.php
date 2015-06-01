<?php
namespace MonologZf2\Factory;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use MonologZf2\Manager\LoggerManagerConfig;
use MonologZf2\Manager\LoggerManager;
use Zend\Stdlib\ArrayUtils;

class LoggerManagerFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $config = $serviceLocator->get('config');

        if (! isset($config['monolog']['manager'])) {
            throw new \Exception(
                'Missing Required Configs for monolog::manager',
                500
            );
        }

        $options = $config['monolog']['manager'];

        if (isset($config['monolog']['logs'])) {
            $options['loggers'] = ArrayUtils::merge(
                $options['loggers'],
                $config['monolog']['logs']
            );
        }

        $config = new LoggerManagerConfig($options);
        $handlerFactory = new MonologHandlerFactory();
        $loggerFactory = new MonologLoggerFactory($handlerFactory);

        $manager = new LoggerManager($config, $loggerFactory, $handlerFactory);

        return $manager;
    }
}
