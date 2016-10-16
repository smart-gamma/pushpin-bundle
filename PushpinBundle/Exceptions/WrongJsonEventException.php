<?php

namespace Gamma\Pushpin\PushpinBundle\Exceptions;

use GripControl\WebSocketEvent;

class WrongJsonEventException extends \RuntimeException
{
    /**
     * @param WebSocketEvent $webSocketEvent
     */
    public function __construct(WebSocketEvent $webSocketEvent)
    {
        $this->message = sprintf('Cannot create JsonTextEvent from WebSocketEvent event: "%s"', json_encode($webSocketEvent));
    }

}
