<?php
namespace MonologZf2\Options;

use Zend\Stdlib\AbstractOptions;

class MonologHandlerOptions extends AbstractOptions
{
    /**
     *
     * @var string
     */
    private $handlerClass;

    /**
     *
     * @var array
     */
    private $args = array();

    public function getHandlerClass(){
        return $this->handlerClass;
    }

    public function setHandlerClass($handlerClass){
        $this->handlerClass = $handlerClass;
    }

    public function getArgs(){
        return $this->args;
    }

    public function setArgs($args){
        $this->args = $args;
    }
}