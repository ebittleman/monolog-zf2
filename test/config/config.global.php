<?php
use Monolog\Logger;
use Monolog\Handler\ErrorLogHandler;

return array(
    'monolog' => array(
        'defaultLogger' => 'Monolog\Log',
        'logs' => array(
            'Monolog\Log' => array(
                'handlers' => array()
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
