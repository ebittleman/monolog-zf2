<?php
namespace MonologZf2\Factory;

use ReflectionClass;
use Monolog\Logger;
use MonologZf2\Options\MonologOptions;
use MonologZf2\Options\MonologLoggerOptions;
use MonologZf2\Options\MonologHandlerOptions;
use Zend\ServiceManager\AbstractFactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class MonologAbstractServiceFactory implements AbstractFactoryInterface
{

    /**
     *
     * @var \MonologZf2\Options\MonologOptions
     */
    private $options;

    public function canCreateServiceWithName(
        ServiceLocatorInterface $serviceLocator,
        $name,
        $requestedName
    ){
        $options = $this->getOptions($serviceLocator);

        return $options->has($name) || $options->has($requestedName);
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
        $options = $this->getOptions($serviceLocator);
        $loggerOptions = $options->get($name);

        if (! $loggerOptions) {
            $loggerOptions = $options->get($requestedName);
        }

        if (! $loggerOptions instanceof MonologLoggerOptions) {
            throw new \Exception('Invalid or missing logger options', 400);
        }

        $log = new Logger($name);

        foreach ($loggerOptions->getHandlers() as $handlerOptions) {
            if (! $handlerOptions instanceof MonologHandlerOptions) {
                throw new \Exception('Invalid HandlerOptions for: ' . $name, 400);
            }

            $className = $handlerOptions->getHandlerClass();

            if (! class_exists($className)) {
                throw new \Exception('Handler class does not exist: ' . $className, 400);
            }

            $ref = new ReflectionClass($className);

            $args = $handlerOptions->getArgs();

            $handler = $ref->newInstanceArgs($args);

            $log->pushHandler($handler);
        }

        return $log;
    }

    public function getOptions(ServiceLocatorInterface $serviceLocator)
    {
        if($this->options) {
            return $this->options;
        }

        if ($serviceLocator->has('MonologZf2\Options\MonologOptions')) {
            $this->options = $serviceLocator->get('MonologZf2\Options\MonologOptions');
        } else {
            $this->options = new MonologOptions();
        }

        return $this->options;
    }

}
