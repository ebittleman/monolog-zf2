<?php
namespace MonologZf2\Factory;

use ReflectionClass;

use Monolog\Logger;
use MonologZf2\Manager\LoggerManager;
use MonologZf2\Options\MonologOptions;
use MonologZf2\Options\MonologLoggerOptions;
use MonologZf2\Options\MonologHandlerOptions;

use Zend\ServiceManager\AbstractFactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class MonologAbstractServiceFactory implements AbstractFactoryInterface
{
    /**
     *
     * @var LoggerManager
     */
    private $manager;

    public function canCreateServiceWithName(
        ServiceLocatorInterface $serviceLocator,
        $name,
        $requestedName
    ){
        $this->manager = $serviceLocator->get('MonologZf2\Manager\LoggerManager');

        return $this->manager->has($requestedName);
    }

    /**
     * Create service with name
     *
     * @param ServiceLocatorInterface $serviceLocator
     * @param $name
     * @param $requestedName
     * @return mixed
    */
    public function createServiceWithName(
        ServiceLocatorInterface $serviceLocator,
        $name,
        $requestedName
    ){
        $this->manager = $serviceLocator->get('MonologZf2\Manager\LoggerManager');

        return $this->manager->get($requestedName);
    }
}
