<?php
namespace MonologZf2\Options;

use Zend\Stdlib\AbstractOptions;

class MonologLoggerOptions extends AbstractOptions
{
    /**
     *
     * @var string
     */
    private $name;

    /**
     *
     * @var array
     */
    private $handlers = array();

    public function __construct($options = null) {
       parent::__construct($options);

       foreach($this->handlers as $index => $handlerOptions){
            if (is_string($handlerOptions)) {
                continue;
            }

            if (! is_array($handlerOptions)) {
                throw new \Exception('Invalid Handler Config', 500);
            }

            $this->handlers[$index] = new MonologHandlerOptions($handlerOptions);
       }
    }


    public function getName()
    {
        return $this->name;
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    public function getHandlers()
    {
        return $this->handlers;
    }

    public function setHandlers($handlers)
    {
        $this->handlers = $handlers;
    }
}
