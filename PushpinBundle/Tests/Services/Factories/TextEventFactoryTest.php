<?php

namespace Gamma\Pushpin\PushpinBundle\Tests\Services\Factories;

use Gamma\Pushpin\PushpinBundle\Services\Events\Json\EventFactory;
use Gamma\Pushpin\PushpinBundle\Services\Events\Json\EventParser;
use Gamma\Pushpin\PushpinBundle\Services\Events\Json\EventSerializer;
use Gamma\Pushpin\PushpinBundle\Services\Factories\TextEventFactory;
use GripControl\WebSocketEvent;

class TextEventFactoryTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var TextEventFactory
     */
    private static $instance;

    public static function setUpBeforeClass()
    {
        self::$instance = new TextEventFactory();
        self::addJsonEventFactory();
    }

    private static function addJsonEventFactory()
    {
        $jsonFactory = new EventFactory(
            new EventParser(),
            new EventSerializer()
        );
        $jsonFactory->configure(
            'Gamma\Pushpin\PushpinBundle\Tests\Utils\Events',
            ['testAction' => ['class' => 'SimpleJsonEvent']]
        );
        self::$instance->addFactory($jsonFactory);
    }

    /**
     * @covers \Gamma\Pushpin\PushpinBundle\Services\Factories\TextEventFactory::getEvent()
     */
    public function testGetEventSuccess()
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
        $jsonEvent = self::$instance->getEvent($event, 'json');

        static::assertInstanceOf('Gamma\Pushpin\PushpinBundle\Tests\Utils\Events\SimpleJsonEvent', $jsonEvent);
        static::assertEquals('testAction', $jsonEvent->getName());
        static::assertEquals('test string', $jsonEvent->string);
        static::assertEquals(true, $jsonEvent->bool);
        static::assertEquals(150, $jsonEvent->int);
        static::assertEquals(150.9999, $jsonEvent->float);
        static::assertEquals(['key' => 'value'], $jsonEvent->array);
        static::assertTrue($jsonEvent->hasSubtypes());
    }

    /**
     * @covers \Gamma\Pushpin\PushpinBundle\Services\Factories\TextEventFactory::getEvent()
     * @dataProvider getWrongTypeData
     */
    public function testGetEventWrongType($type)
    {
        $event = new WebSocketEvent(
            $type,
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
        static::setExpectedException(
            'Gamma\Pushpin\PushpinBundle\Exceptions\Factory\UnsupportedEventTypeException'
        );

        self::$instance->getEvent($event, 'json');
    }

    public function getWrongTypeData()
    {
        return [
            ['CLOSE'],
            ['OPEN'],
            ['PING'],
            ['DISCONNECT'],
            ['UNKNOWN'],
        ];
    }


    /**
     * @covers \Gamma\Pushpin\PushpinBundle\Services\Factories\TextEventFactory::getEvent()
     * @dataProvider getWrongContentData
     */
    public function testGetEventWrongContent($content)
    {
        $event = new WebSocketEvent(
            'TEXT',
            $content
        );
        static::setExpectedException(
            'Gamma\Pushpin\PushpinBundle\Exceptions\WrongJsonEventException'
        );

        self::$instance->getEvent($event, 'json');
    }

    /**
     * @return array
     */
    public function getWrongContentData()
    {
        return [
            ['{"string":"test string","bool":true,"int":150,"float":150.9999,"array": {"key":"value"}}'],
            ['testAction{"string":"test string","bool":true,"int":150,"float":150.9999,"array": {"key":"value"}}'],
            ['testAction:[test]'],
            ['testAction-{"string":"test string","bool":true,"int":150,"float":150.9999,"array": {"key":"value"}}'],
        ];
    }

    /**
     * @covers \Gamma\Pushpin\PushpinBundle\Services\Factories\TextEventFactory::getFormat()
     */
    public function testGetFormat()
    {
        static::assertEquals('TEXT',
            self::$instance->getFormat());
    }
}
