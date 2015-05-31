# Monolog Zend Framework 2 Wrapper

[![Build Status](https://travis-ci.org/ebittleman/monolog-zf2.svg?branch=master)](https://travis-ci.org/ebittleman/monolog-zf2) [![Packagist](https://img.shields.io/packagist/v/ebittleman/monolog-zf2.svg)](https://packagist.org/packages/ebittleman/monolog-zf2)

This project is a basic wrapper for the Monolog logger check it out for all the
bells and whistles [here](https://github.com/Seldaek/monolog).

## Installation


### Install the Package

    composer require ebittleman/monolog-zf2
    
### Enable Zf2 Module

Update your application config to include the module.

    return array(
        'modules' => array(
            ...YOUR MODULES...,
            'MonologZf2'
        ),
        'module_listener_options' => array(
            'config_glob_paths' => array(
                ...YOUR CONFIG PATHS...
            ),
            'module_paths' => array(
                ...YOUR MODULES PATHS...
            )
        )
    );

## Config Example

The following configuration will make 2 different loggers available from the 
service manager where the service name is the array key. Each logger is 
configured with a list of handlers, each of which has a `handlerClass` and 
`args` that will be passed to the handler's constructor. This example can be 
found in <MonlogZf2VendorPath>/config/monolog.global.dist

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


