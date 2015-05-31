<?php
namespace MonologZf2\Initializer;

use Zend\ServiceManager\InitializerInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Psr\Log\LoggerAwareInterface;

class MonologInitializer implements InitializerInterface
{
    public function initialize($instance, ServiceLocatorInterface $serviceLocator)
    {
        if (! $instance instanceof LoggerAwareInterface) {
            return;
        }

        $options = $serviceLocator->get('MonologZf2\Options\MonologOptions');
        $loggerName = $options->getDefaultLogger();

        $className = get_class($instance);

        if (defined($className . '::LOGGER')) {
            $loggerName = $instance::LOGGER;
        }

        $logger = $serviceLocator->get($loggerName);

        $instance->setLogger($logger);
    }
}
