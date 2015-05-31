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
                            __DIR__ . '/../test.log',
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
