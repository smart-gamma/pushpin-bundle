<?php

namespace Gamma\Pushpin\PushpinBundle\Tests\Services;

use Gamma\Pushpin\PushpinBundle\Interfaces\WebSocketChannelInterface;
use Gamma\Pushpin\PushpinBundle\Services\PushpinHelper;
use Gamma\Pushpin\PushpinBundle\Tests\Utils\SimpleChannel;

class PushpinHelperTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var WebSocketChannelInterface
     */
    private static $webSocketChannel;

    /**
     * @var PushpinHelper
     */
    private static $instance;

    public static function setUpBeforeClass()
    {
        self::$webSocketChannel = new SimpleChannel();
        self::$instance = new PushpinHelper();
    }

    /**
     * @covers \Gamma\Pushpin\PushpinBundle\Services\PushpinHelper::subscribeToChannel
     */
    public function testSubscribeToChannel()
    {
        $subscribeEvent = self::$instance->subscribeToChannel(self::$webSocketChannel);

        static::assertInstanceOf('GripControl\WebSocketEvent', $subscribeEvent);
        static::assertEquals('TEXT', $subscribeEvent->type);
        static::assertEquals('c:{"channel":"test-channel","type":"subscribe"}', $subscribeEvent->content);
    }

    /**
     * @covers \Gamma\Pushpin\PushpinBundle\Services\PushpinHelper::unSubscribeFromChannel
     */
    public function testUnSubscribeFromChannel()
    {
        $unSubscribeEvent = self::$instance->unSubscribeFromChannel(self::$webSocketChannel);

        static::assertInstanceOf('GripControl\WebSocketEvent', $unSubscribeEvent);
        static::assertEquals('TEXT', $unSubscribeEvent->type);
        static::assertEquals('c:{"channel":"test-channel","type":"unsubscribe"}', $unSubscribeEvent->content);
    }

    /**
     * @covers \Gamma\Pushpin\PushpinBundle\Services\PushpinHelper::detachConnection
     */
    public function testDetachConnection()
    {
        $detachEvent = self::$instance->detachConnection();

        static::assertInstanceOf('GripControl\WebSocketEvent', $detachEvent);
        static::assertEquals('TEXT', $detachEvent->type);
        static::assertEquals('c:{"type":"detach"}', $detachEvent->content);

    }

    /**
     * @covers \Gamma\Pushpin\PushpinBundle\Services\PushpinHelper::generateTextEvent
     */
    public function testGenerateTextEvent()
    {
        $textEvent = self::$instance->generateTextEvent('test text');

        static::assertInstanceOf('GripControl\WebSocketEvent', $textEvent);
        static::assertEquals('TEXT', $textEvent->type);
        static::assertEquals('test text', $textEvent->content);

    }
}
