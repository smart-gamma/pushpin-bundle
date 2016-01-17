<?php

namespace LiveLife\WebSocketBundle\Services\EventHandlers;

use Gamma\Pushpin\PushpinBundle\Events\Base\AbstractJsonTextEvent;
use Gamma\Pushpin\PushpinBundle\Interfaces\Handlers\JsonEventHandlerInterface;
use LiveLife\WebSocketBundle\Services\EventHandlers\Base\AbstractTextEventHandler;

abstract class AbstractJsonTextEventHandler extends AbstractTextEventHandler implements  JsonEventHandlerInterface
{
    /**
     * {@inheritdoc}
     */
    public function textEventSupported(AbstractJsonTextEvent $event)
    {
        return
            parent::textEventSupported($event) &&
            is_array($event->getDecodedJson());
    }
}
