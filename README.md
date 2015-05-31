# Monolog Zend Framework 2 Wrapper

## Config Example
The following configuration will make 2 different loggers available from the 
service manager where the service name is the array key.

    <?php
    use Monolog\Logger;
    use Monolog\Handler\ErrorLogHandler;
    
    return array(
        'monolog' => array(
            'defaultLogger' => 'Monolog\Log',
            'logs' => array(
                'Monolog\Log' => array(
                        'handlers' => array(
                            array(
                                'handlerClass' => 'Monolog\Handler\StreamHandler',
                                'args' => array(
                                    '/tmp/log.log',
                                    Logger::DEBUG
                                )
                            ),
                            array(
                                'handlerClass' => 'Monolog\Handler\ErrorLogHandler',
                                'args' => array(
                                    ErrorLogHandler::OPERATING_SYSTEM,
                                    Logger::ERROR
                            )
                        )
                    )
                ),
                'Monolog\ErrorLog' => array(
                    'handlers' => array(
                        array(
                            'handlerClass' => 'Monolog\Handler\ErrorLogHandler',
                        )
                    )
                )
            ),
        )
    );

### Usage

    <?php
    namespace MyNamespace;
    
    class SomeFactory
    {
        public function __invoke($serviceLocator)
        {
            $defaultLogger = $serviceLocator->get('Monolog\Log');
            $errorLogger = $serviceLocator->get('Monolog\ErrorLog');
    
            return new Service($defaultLogger, $errorLogger);
        }
    }

## Initializer Dependency Injection

The following service will be intialized with the default logger defined in the
configuration. In order to select a specific logger to be injected you would
un-comment the LOGGER constant of the service.

    <?php
    namespace MyNamespace
    
    use Psr\Log\LoggerAwareInterface;
    use Psr\Log\LoggerAwareTrait;
    
    class ExampleService implements LogAwareInterface
    {
        use LogAwareTrait;
    
        // const LOGGER = 'Someother\Log';
    
        public function serviceCall()
        {
            $this->logger->debug('write this to the log');
        }
    }


