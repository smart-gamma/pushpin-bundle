<?php

namespace Gamma\Pushpin\PushpinBundle\Events\Base;

use Gamma\Pushpin\PushpinBundle\Exceptions\WrongEventException;
use Gamma\Pushpin\PushpinBundle\Interfaces\Events\EventInterface;
use GripControl\WebSocketEvent;

abstract class AbstractEvent extends WebSocketEvent implements EventInterface
{
    /**
     * {@inheritdoc}
     */
    public function __construct($type, $content)
    {
        parent::__construct($type, $content);

        if ($type !== static::getType()) {
            throw new WrongEventException($this, static::getType());
        }
    }
}
