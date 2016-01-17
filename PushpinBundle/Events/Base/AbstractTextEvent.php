<?php

namespace Gamma\Pushpin\PushpinBundle\Events\Base;

use Gamma\Pushpin\PushpinBundle\Exceptions\WrongTextEventException;
use Gamma\Pushpin\PushpinBundle\Interfaces\Events\TextEventInterface;
use GripControl\WebSocketEvent;

abstract class AbstractTextEvent implements TextEventInterface
{
    const EVENT_TYPE = 'TEXT';

    private $webSocketEvent;

    /**
     * {@inheritdoc}
     */
    public function __construct(WebSocketEvent $webSocketEvent)
    {
        if ($webSocketEvent->type !== self::EVENT_TYPE) {
            throw new WrongTextEventException($webSocketEvent);
        }

        $this->webSocketEvent = $webSocketEvent;
    }

    /**
     * {@inheritdoc}
     */
    public function getType()
    {
        return self::EVENT_TYPE;
    }

    /**
     * {@inheritdoc}
     */
    public function getText()
    {
        return $this->webSocketEvent->content;
    }
}
