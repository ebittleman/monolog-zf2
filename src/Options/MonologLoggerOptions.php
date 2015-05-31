<?php
namespace MonologZf2\Options;

use Zend\Stdlib\AbstractOptions;

class MonologLoggerOptions extends AbstractOptions
{
    /**
     *
     * @var array
     */
    private $handlers;

    public function getHandlers()
    {
        return $this->handlers;
    }

    public function setHandlers($handlers)
    {
        $this->handlers = $handlers;
    }
}
