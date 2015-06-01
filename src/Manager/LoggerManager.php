<?php
namespace MonologZf2\Manager;

use MonologZf2\Options\MonologHandlerOptions;
use MonologZf2\Factory\MonologHandlerFactory;
use MonologZf2\Options\MonologLoggerOptions;
use MonologZf2\Factory\MonologLoggerFactory;

use Zend\ServiceManager\ConfigInterface;
use Zend\ServiceManager\Exception\ServiceNotFoundException;
use Zend\ServiceManager\ServiceManager;
use Zend\ServiceManager\ServiceLocatorAwareTrait;
use Zend\ServiceManager\ServiceLocatorAwareInterface;

class LoggerManager extends ServiceManager implements ServiceLocatorAwareInterface
{

    use ServiceLocatorAwareTrait;

    protected $loggerFactory = null;

    protected $handlerFactory = null;

    protected $loggers = array();

    protected $handlers = array();

    public function __construct(
        ConfigInterface $config,
        MonologLoggerFactory $loggerFactory,
        MonologHandlerFactory $handlerFactory
    ) {
        parent::__construct($config);

        $this->loggerFactory = $loggerFactory;
        $this->handlerFactory = $handlerFactory;
    }

    public function get($name)
    {
        $instance = null;
        $cName = '';

        if (isset($this->canonicalNames[$name])) {
            $cName = $this->canonicalNames[$name];
        } else {
            $cName = $this->canonicalizeName($name);
        }

        try {
            $instance = parent::get($cName);

            if (! empty($instance)) {
                return $instance;
            }
        } catch (ServiceNotFoundException $e) {
            if (! $this->has($cName)) {
                throw $e;
            }
        }

        if (array_key_exists($cName, $this->loggers)) {
            $instance = $this->buildLogger($cName);
        }elseif (array_key_exists($cName, $this->handlers)) {
            $instance = $this->buildHandler($cName);
        }

        if (empty($instance)) {
            throw new ServiceNotFoundException(sprintf(
                '%s was unable to fetch or create an instance for %s',
                get_class($this) . '::' . __FUNCTION__,
                $name
            ));
        }

        $this->instances[$cName] = $instance;

        return $instance;
    }

    /**
     * Check for a registered instance
     *
     * @param string|array $name
     * @return bool
     */
    public function has($name)
    {
        $cName = '';
        if (isset($this->canonicalNames[$name])) {
            $cName = $this->canonicalNames[$name];
        } else {
            $cName = $this->canonicalizeName($name);
        }

        if (
            array_key_exists($cName, $this->loggers) ||
            array_key_exists($cName, $this->handlers)
        ) {
            return true;
        }

        if (parent::has($name)) {
            return true;
        }
    }

    public function setLogger($name, $loggerOptions)
    {
        $cName = $this->canonicalizeName($name);

        if (! isset($loggerOptions['name'])) {
            $loggerOptions['name'] = $cName;
        }

        $this->loggers[$cName] = new MonologLoggerOptions($loggerOptions);
    }

    public function setHandler($name, $handlerOptions)
    {
        $cName = $this->canonicalizeName($name);
        $this->handlers[$cName] = new MonologHandlerOptions($handlerOptions);
    }

    private function buildLogger($cname)
    {
        $options = $this->loggers[$cname];

        return $this->loggerFactory->createLogger($options, $this);
    }

    private function buildHandler($cname)
    {
        $options = $this->handlers[$cname];

        return $this->handlerFactory->createHandler($options);
    }
}
