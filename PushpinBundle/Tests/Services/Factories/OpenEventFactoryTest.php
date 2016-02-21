<?php

namespace Gamma\Pushpin\PushpinBundle\Tests\Services\Factories;

use Gamma\Pushpin\PushpinBundle\Services\Factories\OpenEventFactory;
use GripControl\WebSocketEvent;

class OpenEventFactoryTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var OpenEventFactory
     */
    private static $instance;

    public static function setUpBeforeClass()
    {
        self::$instance = new OpenEventFactory();
    }

    /**
     * @covers \Gamma\Pushpin\PushpinBundle\Services\Factories\OpenEventFactory::getEvent()
     */
    public function testGetEventSuccess()
    {
        $event = new WebSocketEvent('OPEN');
        $openEvent = self::$instance->getEvent($event);

        static::assertInstanceOf('Gamma\Pushpin\PushpinBundle\Events\OpenEvent', $openEvent);
    }

    /**
     * @covers \Gamma\Pushpin\PushpinBundle\Services\Factories\OpenEventFactory::getEvent()
     * @dataProvider getWrongTypeData
     */
    public function testGetEventWrongType($type)
    {
        $event = new WebSocketEvent($type);
        static::setExpectedException(
            'Gamma\Pushpin\PushpinBundle\Exceptions\Factory\UnsupportedEventTypeException'
        );

        self::$instance->getEvent($event);
    }

    public function getWrongTypeData()
    {
        return [
            ['CLOSE'],
            ['TEXT'],
            ['PING'],
            ['DISCONNECT'],
            ['UNKNOWN'],
        ];
    }

    /**
     * @covers \Gamma\Pushpin\PushpinBundle\Services\Factories\OpenEventFactory::getFormat()
     */
    public function testGetFormat()
    {
        static::assertEquals('OPEN',
            self::$instance->getFormat());
    }

}
