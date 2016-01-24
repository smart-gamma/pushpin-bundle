<?php

namespace Gamma\Pushpin\PushpinBundle\Tests\Services\Events;

use Gamma\Pushpin\PushpinBundle\Services\Events\JsonEventParser;
use GripControl\WebSocketEvent;

class JsonEventParserTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var JsonEventParser
     */
    private static $instance;

    /**
     * @var WebSocketEvent
     */
    private static $event;

    public static function setUpBeforeClass()
    {
        self::$instance = new JsonEventParser();
        self::$event = new WebSocketEvent(
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
    }

    /**
     * @covers \Gamma\Pushpin\PushpinBundle\Services\Events\JsonEventParser::getEventName
     */
    public function testGetEventName()
    {
        static::assertEquals('testAction', self::$instance->getEventName(self::$event));
    }

    /**
     * @covers \Gamma\Pushpin\PushpinBundle\Services\Events\JsonEventParser::getEventJson
     */
    public function testGetEventJson()
    {
        static::assertEquals('{
                "string":"test string",
                "bool":true,
                "int":150,
                "float":150.9999,
                "array": {
                    "key":"value"
                }
            }', self::$instance->getEventJson(self::$event));
    }
}
