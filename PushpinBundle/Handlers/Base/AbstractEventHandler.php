<?php

namespace Gamma\Pushpin\PushpinBundle\Handlers\Base;

use Gamma\Pushpin\PushpinBundle\Interfaces\Events\EventInterface;
use Gamma\Pushpin\PushpinBundle\Interfaces\Handlers\EventHandlerInterface;

abstract class AbstractEventHandler implements EventHandlerInterface
{
    /**
     * {@inheritdoc}
     */
    public function eventSupported(EventInterface $event)
    {
        return $event->getType() === static::$eventType;
    }

    /**
     * {@inheritdoc}
     */
    public function getEventType()
    {
        return static::$eventType;
    }
}
