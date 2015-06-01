<?php
use Monolog\Logger;
use Monolog\Handler\ErrorLogHandler;

return array(
    'monolog' => array(
        'defaultLogger' => 'Monolog\Log',
        'manager' => array(
                'loggers' => array(
                    'Monolog\ErrorLogFromManager' => array(
                        'handlers' => array(
                            'Monolog\BasicErrorHandler',
                        ),
                    ),
                ),
                'handlers' => array(
                    'Monolog\BasicErrorHandler' => array(
                        'handlerClass' => 'Monolog\Handler\ErrorLogHandler',
                    )
                ),
        ),
        'logs' => array(
            'Monolog\Log' => array(
                'handlers' => array(
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
