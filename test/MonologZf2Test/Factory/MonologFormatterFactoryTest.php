<?php
namespace MonologZf2Test\Factory;

use MailgunZf2Test\UnitTest;
use MonologZf2\Factory\MonologFormatterFactory;

class MonologFormatterFactoryTest extends UnitTest
{
    public function testExists()
    {
        $this->assertInstanceOf(
            'MonologZf2\Factory\MonologFormatterFactory',
            new MonologFormatterFactory()
        );
    }

    public function testCreateFormatter()
    {
        $formatterOptionsMock = $this->getMockBuilder('MonologZf2\Options\MonologFormatterOptions')
            ->disableOriginalConstructor()
            ->getMock();

        $formatterOptionsMock->expects($this->once())
            ->method('getFormatterClass')
            ->will($this->returnValue('Monolog\Formatter\LineFormatter'));

        $formatterOptionsMock->expects($this->once())
            ->method('getArgs')
            ->will($this->returnValue(array()));

        $factory = new MonologFormatterFactory();
        $formatter = $factory->createFormatter($formatterOptionsMock);

        $this->assertInstanceOf('Monolog\Formatter\LineFormatter', $formatter);
    }
}
