<?php
namespace MonologZf2\Factory;

use Monolog\Handler\HandlerInterface;
use MonologZf2\Options\MonologLoggerOptions;
use Zend\ServiceManager\ServiceLocatorInterface;
use Monolog\Logger;
use MonologZf2\Options\MonologHandlerOptions;

class MonologLoggerFactory
{
    /**
     *
     * @var MonologHandlerFactory
     */
    private $handlerFactory;

    public function __construct(MonologHandlerFactory $handlerFactory)
    {
        $this->handlerFactory = $handlerFactory;
    }

    public function createLogger(
        MonologLoggerOptions $options,
        ServiceLocatorInterface $serviceLocator
    ) {
        $log = new Logger($options->getName());

        foreach ($options->getHandlers() as $handlerOptions) {
            if ($handlerOptions instanceof MonologHandlerOptions) {
                /** @var HandlerInterface $handler */
                $handler = $this->handlerFactory->createHandler($handlerOptions);
            } elseif (is_string($handlerOptions)
                && $serviceLocator->has($handlerOptions)
            ) {
                /** @var HandlerInterface $handler */
                $handler = $serviceLocator->get($handlerOptions);
            } else {
                throw new \Exception('Invalid Handler Not Found');
            }

            $log->pushHandler($handler);
        }

        return $log;
    }
}
