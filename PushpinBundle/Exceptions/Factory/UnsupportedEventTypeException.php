<?php

namespace Gamma\Pushpin\PushpinBundle\Exceptions\Factory;

use Gamma\Pushpin\PushpinBundle\Interfaces\Factory\EventFactoryInterface;
use GripControl\WebSocketEvent;

class UnsupportedEventTypeException extends \RuntimeException
{
    /**
     * @param EventFactoryInterface $eventFactory
     * @param WebSocketEvent        $event
     */
    public function __construct(EventFactoryInterface $eventFactory, WebSocketEvent $event)
    {
        $this->message = sprintf(
            'Event factory "%s" does not supports "%s" WebSocketEvents type',
            get_class($eventFactory),
            $event->type
        );
    }
}
