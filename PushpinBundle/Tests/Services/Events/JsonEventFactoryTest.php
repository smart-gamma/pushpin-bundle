<?php

namespace Gamma\Pushpin\PushpinBundle\Tests\Services\Events;

use Gamma\Pushpin\PushpinBundle\Services\Events\JsonEventFactory;
use Gamma\Pushpin\PushpinBundle\Services\Events\JsonEventParser;
use Gamma\Pushpin\PushpinBundle\Services\Events\JsonEventSerializer;
use GripControl\WebSocketEvent;

class JsonEventFactoryTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var JsonEventFactory
     */
    private static $instance;

    public static function setUpBeforeClass()
    {
        self::$instance = new JsonEventFactory(
            new JsonEventParser(),
            new JsonEventSerializer()
        );
    }

    public function setUp()
    {
        self::$instance->configure(
            'Gamma\Pushpin\PushpinBundle\Tests\Utils\Events',
            ['testAction' => 'SimpleJsonEvent']
            );
    }

    /**
     * @covers \Gamma\Pushpin\PushpinBundle\Services\Events\JsonEventFactory::getJsonEvents
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
        $events = self::$instance->getJsonEvents([$event]);
        $deSerialized = $events[0];

        static::assertInstanceOf('Gamma\Pushpin\PushpinBundle\Tests\Utils\Events\SimpleJsonEvent', $deSerialized);
        static::assertEquals('test string', $deSerialized->string);
        static::assertEquals(true, $deSerialized->bool);
        static::assertEquals(150, $deSerialized->int);
        static::assertEquals(150.9999, $deSerialized->float);
        static::assertEquals(['key' => 'value'], $deSerialized->array);
    }
}
