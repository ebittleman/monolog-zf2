<?php
namespace MonologZfTest;

use MailgunZf2Test\UnitTest;
use Monolog\Handler\TestHandler;

class MonologTest extends UnitTest
{
    public function testLogGet()
    {
        $log = $this->sm->get('Monolog\Log');

        $this->assertInstanceOf('Monolog\Logger', $log);
    }


    public function testLogWrite()
    {
        $handler = new TestHandler;
        $log = $this->sm->get('Monolog\Log');

        $log->pushHandler($handler);

        $log->debug('logline');

        $this->assertTrue($handler->hasDebugRecords());

        $records = $handler->getRecords();
        $record = $records[0];

        $this->assertEquals('logline', $record['message']);
    }
}
