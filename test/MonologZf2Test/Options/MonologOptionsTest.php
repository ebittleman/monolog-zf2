<?php
namespace MailgunZf2Test\Options;

use MailgunZf2Test\UnitTest;
use MonologZf2\Options\MonologOptions;

class MonologOptionsTest extends UnitTest
{
    /**
     *
     * @var MonologOptions
     */
    private $options;

    protected function setUp()
    {
        parent::setUp();

        $this->options = $this->sm->get('MonologZf2\Options\MonologOptions');
    }

    public function testExists()
    {
        $this->assertInstanceOf(
            'MonologZf2\Options\MonologOptions',
            $this->options
        );
    }

    public function testLoggers()
    {
        $this->assertTrue($this->options->has('Monolog\Log'));
        $this->assertTrue($this->options->has('Monolog\ErrorLog'));
    }

    public function testMonologLog()
    {
        $options = $this->options->get('Monolog\Log');
        $name = $options->getName();
        $handlers = $options->getHandlers();

        $this->assertEquals('Monolog\Log', $name);
        $this->assertNotEmpty($handlers);
    }
}
