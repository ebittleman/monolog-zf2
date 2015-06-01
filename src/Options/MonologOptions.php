<?php
namespace MonologZf2\Options;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class MonologOptions implements FactoryInterface
{
    /**
     *
     * @var string
     */
    private $defaultLogger;

    /**
     *
     * @var array<\MonologZf2\Options\MonologLoggerOptions>
     */
    private $loggers;

    public function __construct($options = array())
    {
        $this->loggers = array();

        $this->defaultLogger = isset($options['defaultLogger'])?
            $options['defaultLogger'] :
            'Monolog';

        $this->loggers = isset($options['logs'])? $options['logs'] : array();
    }

    public function getDefaultLogger(){
        return $this->defaultLogger;
    }

    public function setDefaultLogger($defaultLogger){
        $this->defaultLogger = $defaultLogger;
    }

    public function has($name) {
        return isset($this->loggers[$name]);
    }

    public function get($name) {
        if (! $this->has($name)) {
            return null;
        }

        $loggerOptions = $this->loggers[$name];

        if (
            $loggerOptions instanceof MonologLoggerOptions ||
            is_string($loggerOptions)
        ) {
            return $loggerOptions;
        }

        if (! isset($loggerOptions['name'])) {
            $loggerOptions['name'] = $name;
        }

        $loggerOptions = new MonologLoggerOptions($loggerOptions);

        $this->loggers[$name] = $loggerOptions;

        return $loggerOptions;
    }

    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $config = $serviceLocator->get('config');
        $monologOptions = array();

        if (isset($config['monolog'])) {
            $monologOptions = $config['monolog'];
        }

        return new MonologOptions($monologOptions);
    }
}
