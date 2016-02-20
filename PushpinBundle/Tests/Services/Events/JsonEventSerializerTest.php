<?php

namespace Gamma\Pushpin\PushpinBundle\Tests\Services\Events;

use Gamma\Pushpin\PushpinBundle\Services\Events\Json\EventSerializer;
use Gamma\Pushpin\PushpinBundle\Tests\Utils\Events\SimpleJsonEvent;

class JsonEventSerializerTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var EventSerializer
     */
    private static $instance;

    public static function setUpBeforeClass()
    {
        self::$instance = new EventSerializer();
    }

    public function testDeserialize()
    {
        $event = new SimpleJsonEvent(
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
        static::assertEquals('testAction', $event->getName());

        $deSerialized = self::$instance->deserialize($event);

        static::assertInstanceOf('Gamma\Pushpin\PushpinBundle\Tests\Utils\Events\SimpleJsonEvent', $deSerialized);
        static::assertEquals('test string', $deSerialized->string);
        static::assertEquals(true, $deSerialized->bool);
        static::assertEquals(150, $deSerialized->int);
        static::assertEquals(150.9999, $deSerialized->float);
        static::assertEquals(['key' => 'value'], $deSerialized->array);
    }
}
