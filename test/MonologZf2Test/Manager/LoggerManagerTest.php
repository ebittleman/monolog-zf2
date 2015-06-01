<?php
namespace MonologZf2Test\Manager;

use MailgunZf2Test\UnitTest;
use MonologZf2\Manager\LoggerManager;

class LoggerManagerTest extends UnitTest
{
    /**
     *
     * @var LoggerManager
     */
    private $manager;

    protected function setUp()
    {
        parent::setUp();
        $this->manager = $this->sm->get('MonologZf2\Manager\LoggerManager');
    }

    public function testExists()
    {
        $this->assertInstanceOf(
            'MonologZf2\Manager\LoggerManager',
            $this->manager
        );
    }

    public function testGetLogger()
    {
        $logger = $this->manager->get('Monolog\ErrorLogFromManager');

        $this->assertInstanceOf('Monolog\Logger', $logger);
    }
}
