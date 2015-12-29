<?php
namespace MonologZf2\Options;

use Zend\Stdlib\AbstractOptions;

class MonologFormatterOptions extends AbstractOptions
{
    /**
     * @var string
     */
    private $formatterClass;

    /**
     * @var array
     */
    private $args = array();

    public function getFormatterClass()
    {
        return $this->formatterClass;
    }

    public function setFormatterClass($formatterClass)
    {
        $this->formatterClass = $formatterClass;
    }

    public function getArgs()
    {
        return $this->args;
    }

    public function setArgs($args)
    {
        $this->args = $args;
    }
}
