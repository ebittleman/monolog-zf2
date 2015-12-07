<?php
namespace MonologZf2Test\Factory;

use MailgunZf2Test\UnitTest;
use MonologZf2\Factory\MonologHandlerFactory;
use MonologZf2\Options\MonologHandlerOptions;

class MonologHandlerFactoryTest extends UnitTest
{
    public function testExists()
    {
        $this->assertInstanceOf(
            'MonologZf2\Factory\MonologHandlerFactory',
            new MonologHandlerFactory()
        );
    }

    public function testCreateHandler()
    {
        $handlerOptionsMock = $this->getMockBuilder('MonologZf2\Options\MonologHandlerOptions')
            ->disableOriginalConstructor()
            ->getMock();

        $handlerOptionsMock->expects($this->once())
            ->method('getHandlerClass')
            ->will($this->returnValue('Monolog\Handler\ErrorLogHandler'));

        $handlerOptionsMock->expects($this->once())
            ->method('getArgs')
            ->will($this->returnValue(array()));

        $factory = new MonologHandlerFactory();
        $formatter = $factory->createHandler($handlerOptionsMock);

        $this->assertInstanceOf('Monolog\Handler\ErrorLogHandler', $formatter);
    }

    public function testCreateHandlerWithFormatter()
    {
        $handlerOptions = new MonologHandlerOptions(array(
            'handlerClass' => 'Monolog\Handler\ErrorLogHandler',
            'args' => array(),
            'formatter' => array(
                'formatterClass' => 'Monolog\Formatter\LineFormatter',
                'args' => array("%message%"),
            )
        ));

        $factory = new MonologHandlerFactory();
        $handler = $factory->createHandler($handlerOptions);

        $this->assertInstanceOf('Monolog\Handler\ErrorLogHandler', $handler);
    }
}
