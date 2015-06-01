<?php
namespace MonologZfTest;

use MailgunZf2Test\UnitTest;
use Monolog\Handler\TestHandler;
use Monolog\Logger;
use Monolog\Handler\ErrorLogHandler;

class MonologTest extends UnitTest
{
    /**
     *
     * @var Logger
     */
    private $log;
    protected function setUp()
    {
        parent::setUp();
        $this->log = $this->sm->get('Monolog\Log');
    }
    public function testLogGet()
    {
        $this->assertInstanceOf('Monolog\Logger', $this->log);
    }

    public function testErrorLogHandlerAssertions()
    {
        $handlers = $this->log->getHandlers();

        $hasErrorHandler = false;

        foreach ($handlers as $handler) {
            if (! $handler instanceof ErrorLogHandler) {
                continue;
            }
            $hasErrorHandler = true;
            $this->assertEquals(Logger::ERROR, $handler->getLevel());
        }

        $this->assertTrue($hasErrorHandler);
    }

    public function testLogWrite()
    {
        $handler = new TestHandler;
        $log = $this->log;

        $log->pushHandler($handler);

        $log->debug('logline');

        $this->assertTrue($handler->hasDebugRecords());

        $records = $handler->getRecords();
        $record = $records[0];

        $this->assertEquals('logline', $record['message']);
    }
}
