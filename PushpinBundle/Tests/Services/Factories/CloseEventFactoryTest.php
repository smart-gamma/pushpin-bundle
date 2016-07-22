<?php

namespace Gamma\Pushpin\PushpinBundle\Tests\Services\Factories;

use Gamma\Pushpin\PushpinBundle\Services\Factories\CloseEventFactory;
use GripControl\WebSocketEvent;

class CloseEventFactoryTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var CloseEventFactory
     */
    private static $instance;

    public static function setUpBeforeClass()
    {
        self::$instance = new CloseEventFactory();
    }

    /**
     * @covers \Gamma\Pushpin\PushpinBundle\Services\Factories\CloseEventFactory::getEvent()
     */
    public function testGetEventSuccess()
    {
        $event = new WebSocketEvent('CLOSE');
        $closeEvent = self::$instance->getEvent($event);

        static::assertInstanceOf('Gamma\Pushpin\PushpinBundle\Events\CloseEvent', $closeEvent);
    }

    /**
     * @covers \Gamma\Pushpin\PushpinBundle\Services\Factories\CloseEventFactory::getEvent()
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
            ['OPEN'],
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
        static::assertEquals('CLOSE',
            self::$instance->getFormat());
    }

}
