<?php

namespace Gamma\Pushpin\PushpinBundle\Tests\Services\Events\Json;

use Gamma\Pushpin\PushpinBundle\Services\Events\Json\EventFactory;
use Gamma\Pushpin\PushpinBundle\Services\Events\Json\EventParser;
use Gamma\Pushpin\PushpinBundle\Services\Events\Json\EventSerializer;
use GripControl\WebSocketEvent;

class JsonEventFactoryTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var EventFactory
     */
    private static $instance;

    public static function setUpBeforeClass()
    {
        self::$instance = new EventFactory(
            new EventParser(),
            new EventSerializer()
        );
    }

    public function setUp()
    {
        self::$instance->configure(
            'Gamma\Pushpin\PushpinBundle\Tests\Utils\Events',
                ['testAction' => ['class' => 'SimpleJsonEvent']]
            );
    }

    /**
     * @covers \Gamma\Pushpin\PushpinBundle\Services\Events\Json\EventFactory::getEvent
     */
    public function testGetJsonEvents()
    {
        $event = new WebSocketEvent(
            'TEXT',
            'testAction:{
                "string":"test string",
                "bool":true,
                "int":150,
                "float":150.9999,
                "array": {
                    "key":"value"
                }
            }'
        );
        $jsonEvent = self::$instance->getEvent($event);

        static::assertInstanceOf('Gamma\Pushpin\PushpinBundle\Tests\Utils\Events\SimpleJsonEvent', $jsonEvent);
        static::assertEquals('testAction', $jsonEvent->getName());
        static::assertEquals('test string', $jsonEvent->string);
        static::assertEquals(true, $jsonEvent->bool);
        static::assertEquals(150, $jsonEvent->int);
        static::assertEquals(150.9999, $jsonEvent->float);
        static::assertEquals(['key' => 'value'], $jsonEvent->array);
        static::assertTrue($jsonEvent->hasSubtypes());
    }
}
