<?php
namespace MonologZf2\Options;

use Zend\Stdlib\AbstractOptions;

class MonologHandlerOptions extends AbstractOptions
{
    /**
     * @var string
     */
    private $handlerClass;

    /**
     * @var array
     */
    private $args = array();

    /**
     * @var MonologFormatterOptions
     */
    private $formatter;

    public function getHandlerClass()
    {
        return $this->handlerClass;
    }

    public function setHandlerClass($handlerClass)
    {
        $this->handlerClass = $handlerClass;
    }

    public function getArgs()
    {
        return $this->args;
    }

    public function setArgs($args)
    {
        $this->args = $args;
    }

    public function getFormatter()
    {
        return $this->formatter;
    }

    public function setFormatter($formatter)
    {
        if (!empty($formatter) && is_array($formatter)) {
            $this->formatter = new MonologFormatterOptions($formatter);
        }
    }
}
