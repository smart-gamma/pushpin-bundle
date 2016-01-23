<?php

namespace Gamma\Pushpin\PushpinBundle\Services;

use GripControl\GripControl;
use GripControl\GripPubControl;
use GripControl\WebSocketEvent;
use Gamma\Pushpin\PushpinBundle\Interfaces\WebSocketChannelInterface;
use Gamma\Pushpin\PushpinBundle\Messages\GammaWebSocketMessage;

class PushpinHelper
{
    /** @var GripPubControl */
    private $gripPubControl;

    /**
     * @param $pushpinURI
     */
    public function setPushpinControlURI($pushpinURI)
    {
        $this->setGripPubControl(
                new GripPubControl(GripControl::parse_grip_uri($pushpinURI)
            )
        );
    }

    /**
     * @param $gripPubControl
     */
    public function setGripPubControl($gripPubControl)
    {
        $this->gripPubControl = $gripPubControl;
    }

    /**
     * @param $channel
     * @param $message
     */
    public function sendWsMessageToChannel(WebSocketChannelInterface $channel, $message)
    {
        $wsMessage = new GammaWebSocketMessage($message);

        $this->gripPubControl->publish($channel->getChannelName(), $wsMessage);
    }

    /**
     * @param WebSocketChannelInterface $channel
     *
     * @return WebSocketEvent
     */
    public function subscribeToChannel(WebSocketChannelInterface $channel)
    {
        $webSocketEvent = new WebSocketEvent('TEXT', 'c:'.
            GripControl::websocket_control_message('subscribe',
                ['channel' => $channel->getChannelName()]
            )
        );

        return $webSocketEvent;
    }

    /**
     * @param WebSocketChannelInterface $channel
     *
     * @return WebSocketEvent
     */
    public function unSubscribeFromChannel(WebSocketChannelInterface $channel)
    {
        $webSocketEvent = new WebSocketEvent('TEXT', 'c:'.
            GripControl::websocket_control_message('unsubscribe',
                ['channel' => $channel->getChannelName()]
            )
        );

        return $webSocketEvent;
    }

    /**
     * @return WebSocketEvent
     */
    public function detachConnection()
    {
        $webSocketEvent = new WebSocketEvent('TEXT', 'c:'.
            GripControl::websocket_control_message('detach')
        );

        return $webSocketEvent;
    }

    /**
     * @param $content
     *
     * @return WebSocketEvent
     */
    public function generateTextEvent($content)
    {
        $webSocketEvent = new WebSocketEvent('TEXT', $content);

        return $webSocketEvent;
    }
}
