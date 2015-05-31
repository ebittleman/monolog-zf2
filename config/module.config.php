<?php

return array(
    'service_manager' => array(
        'abstract_factories' => array(
            'MonologZf2\Factory\MonologAbstractServiceFactory',
        ),

        'initializers' => array(
            'MonologZf2\Initializer\MonologInitializer',
        ),

        'factories' => array(
            'MonologZf2\Options\MonologOptions' => 'MonologZf2\Options\MonologOptions',
        ),
    ),
);
