<?php

namespace Gamma\Pushpin\PushpinBundle\Handlers\Base;

use Gamma\Pushpin\PushpinBundle\Events\Base\AbstractJsonTextEvent;
use Gamma\Pushpin\PushpinBundle\Interfaces\Handlers\JsonEventHandlerInterface;

abstract class AbstractJsonTextEventHandler extends AbstractTextEventHandler implements JsonEventHandlerInterface
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
