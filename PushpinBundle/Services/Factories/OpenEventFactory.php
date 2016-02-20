<?php

namespace Gamma\Pushpin\PushpinBundle\Services\Factories;

use Gamma\Pushpin\PushpinBundle\Events\OpenEvent;
use Gamma\Pushpin\PushpinBundle\Interfaces\Events\OpenEventInterface;
use Gamma\Pushpin\PushpinBundle\Interfaces\Factory\EventFactoryInterface;
use GripControl\WebSocketEvent;

class OpenEventFactory implements EventFactoryInterface
{
    /**
     * {@inheritdoc}
     */
    public function getEvent(WebSocketEvent $webSocketEvent, $format = null)
    {
        return new OpenEvent($webSocketEvent->type, $webSocketEvent->content);
    }

    /**
     * {@inheritdoc}
     */
    public function getFormat()
    {
        return OpenEventInterface::EVENT_TYPE;
    }
}
