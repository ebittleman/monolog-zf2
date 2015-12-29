<?php
namespace MonologZf2\Factory;

use MonologZf2\Options\MonologFormatterOptions;
use Monolog\Formatter\FormatterInterface;

use ReflectionClass;

class MonologFormatterFactory
{
    /**
     * @param MonologFormatterOptions $options
     * @return FormatterInterface
     * @throws \Exception
     */
    public function createFormatter(MonologFormatterOptions $options)
    {
        $className = $options->getFormatterClass();

        if (! class_exists($className)) {
            throw new \Exception('Formatter class does not exist: ' . $className, 400);
        }

        $ref = new ReflectionClass($className);

        $args = $options->getArgs();

        $formatter = $ref->newInstanceArgs($args);

        if (! $formatter instanceof FormatterInterface) {
            throw new \Exception('Invalid Monolog Formatter');
        }

        return $formatter;
    }
}
