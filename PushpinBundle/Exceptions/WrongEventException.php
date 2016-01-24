<?php

namespace Gamma\Pushpin\PushpinBundle\Exceptions;

use GripControl\WebSocketEvent;

class WrongEventException extends \RuntimeException
{
    public function __construct(WebSocketEvent $event, $expectedType)
    {
        $this->message = sprintf(
            'Invalid WebSocketEvent received. Expected type was "%s", but actual "%s"',
            $expectedType,
            $event->type
        );
    }
}
