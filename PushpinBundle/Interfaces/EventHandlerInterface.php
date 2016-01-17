<?php

namespace Gamma\Pushpin\PushpinBundle\Interfaces;

use GripControl\WebSocketEvent;

interface EventHandlerInterface
{
    /**
     * @param WebSocketEvent $webSocketEvent
     *
     * @return WebSocketEvent
     */
    public function handle(WebSocketEvent $webSocketEvent);

    /**
     * @return string
     */
    public function getEventName();

    /**
     * @param WebSocketEvent $webSocketEvent
     *
     * @return bool
     */
    public static function eventSupported(WebSocketEvent $webSocketEvent);
}
