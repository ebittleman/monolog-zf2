<?php
namespace MonologZf2\Manager;

use Zend\ServiceManager\ServiceManager;
use Zend\ServiceManager\Config;

class LoggerManagerConfig extends Config
{
    public function getLoggers()
    {
        return (isset($this->config['loggers'])) ? $this->config['loggers'] : array();
    }

    public function getHandlers()
    {
        return (isset($this->config['handlers'])) ? $this->config['handlers'] : array();
    }

    public function configureServiceManager(ServiceManager $serviceManager)
    {
        parent::configureServiceManager($serviceManager);

        if (! $serviceManager instanceof LoggerManager) {
            return;
        }

        foreach ($this->getLoggers() as $name => $loggerOptions) {
            $serviceManager->setLogger($name, $loggerOptions);
        }

        foreach ($this->getHandlers() as $name => $handlerOptions) {
            $serviceManager->setHandler($name, $handlerOptions);
        }
    }
}
