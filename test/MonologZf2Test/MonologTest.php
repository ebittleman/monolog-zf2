<?php
namespace MonologZfTest;

use MailgunZf2Test\UnitTest;

class MonologTest extends UnitTest
{
    public function testLog()
    {
        $log = $this->sm->get('Monolog\Log');

        $this->assertInstanceOf('Monolog\Logger', $log);
    }
}
