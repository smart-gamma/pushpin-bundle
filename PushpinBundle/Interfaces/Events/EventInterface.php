<?php

namespace Gamma\Pushpin\PushpinBundle\Interfaces\Events;

use GripControl\WebSocketEvent;

interface EventInterface
{
    /**
     * @return string
     */
    public function getType();

    /**
     * @param WebSocketEvent $webSocketEvent
     */
    public function __construct(WebSocketEvent $webSocketEvent);
}
