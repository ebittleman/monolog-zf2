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

        $loggers = isset($options['logs'])? $options['logs'] : array();

        foreach ($loggers as $serviceName => $logOptions)
        {
            $handlers = array();

            if (! empty($logOptions['handlers'])) {
                foreach($logOptions['handlers'] as $handlerOptions) {
                    $handlers[] = new MonologHandlerOptions($handlerOptions);
                }
            }

            $logOptions['handlers'] = $handlers;

            $this->loggers[$serviceName] = new MonologLoggerOptions($logOptions);
        }
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

        return $this->loggers[$name];
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
