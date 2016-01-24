<?php

namespace Gamma\Pushpin\PushpinBundle\Handlers\Base;

use Gamma\Pushpin\PushpinBundle\Events\Base\AbstractEvent;
use Gamma\Pushpin\PushpinBundle\Interfaces\Handlers\EventHandlerInterface;

abstract class AbstractEventHandler implements EventHandlerInterface
{
    /**
     * {@inheritdoc}
     */
    public function getEventType()
    {
        return static::EVENT_TYPE;
    }

    /**
     * {@inheritdoc}
     */
    public function eventSupported(AbstractEvent $event)
    {
        return $this->getEventType() === $event->getType();
    }
}
