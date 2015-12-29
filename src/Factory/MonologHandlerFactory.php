<?php
namespace MonologZf2\Factory;

use MonologZf2\Options\MonologHandlerOptions;
use Monolog\Handler\HandlerInterface;

use ReflectionClass;

class MonologHandlerFactory
{
    public function createHandler(MonologHandlerOptions $options)
    {
        $className = $options->getHandlerClass();

        if (! class_exists($className)) {
            throw new \Exception('Handler class does not exist: ' . $className, 400);
        }

        $ref = new ReflectionClass($className);

        $args = $options->getArgs();

        $handler = $ref->newInstanceArgs($args);

        if (! $handler instanceof HandlerInterface) {
            throw new \Exception('Invalid Monolog Handler');
        }

        $this->addFormatter($handler, $options);

        return $handler;
    }

    private function addFormatter(HandlerInterface $handler, MonologHandlerOptions $options)
    {
        if ($formatterOptions = $options->getFormatter()) {
            $formatterFactory = new MonologFormatterFactory();
            $formatter = $formatterFactory->createFormatter($formatterOptions);

            $handler->setFormatter($formatter);
        }
    }
}
