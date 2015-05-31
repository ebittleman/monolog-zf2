<?php
namespace MailgunZf2Test;

use Zend\Mvc\Application;
use Zend\ServiceManager\ServiceManager;
use Zend\EventManager\EventManager;

abstract class UnitTest extends \PHPUnit_Framework_TestCase
{
    /**
     *
     * @var Application
     */
    protected $app = null;

    /**
     *
     * @var ServiceManager
     */
    protected $sm = null;

    /**
     *
     * @var EventManager
     */
    protected $evm = null;

    public function __construct($name = null, array $data = array(), $dataName = '')
    {
        parent::__construct($name, $data, $dataName);

        $this->app = \Bootstrap::$app;
        $this->sm = $this->app->getServiceManager();
        $this->evm = $this->app->getEventManager();
    }
}
