<?php

namespace Gamma\Pushpin\PushpinBundle\Handlers\Base;

use Gamma\Pushpin\PushpinBundle\Events\Base\AbstractTextEvent;
use Gamma\Pushpin\PushpinBundle\Interfaces\Handlers\EventHandlerInterface;

abstract class AbstractTextEventHandler extends AbstractEventHandler implements EventHandlerInterface
{
    protected static $eventType = AbstractTextEvent::EVENT_TYPE;

    /**
     * {@inheritdoc}
     */
    public function textEventSupported(AbstractTextEvent $event)
    {
        return
            parent::eventSupported($event) && is_string($event->getText());
    }

    /**
     * @param AbstractTextEvent $event
     *
     * @return bool
     */
    abstract protected function validateData(AbstractTextEvent $event);
}
