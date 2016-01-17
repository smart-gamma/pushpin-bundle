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
        $webSocketSubscribeEvent = self::$instance->subscribeToChannel(self::$webSocketChannel);

        static::assertEquals('TEXT', $webSocketSubscribeEvent->type);
        static::assertEquals('c:{"channel":"test-channel","type":"subscribe"}', $webSocketSubscribeEvent->content);
    }

    /**
     * @covers \Gamma\Pushpin\PushpinBundle\Services\PushpinHelper::unSubscribeFromChannel
     */
    public function testUnSubscribeFromChannel()
    {
        $webSocketUnSubscribeEvent = self::$instance->unSubscribeFromChannel(self::$webSocketChannel);

        static::assertEquals('TEXT', $webSocketUnSubscribeEvent->type);
        static::assertEquals('c:{"channel":"test-channel","type":"unsubscribe"}', $webSocketUnSubscribeEvent->content);
    }
}
