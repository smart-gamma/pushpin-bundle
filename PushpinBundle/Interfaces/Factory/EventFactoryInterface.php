<?php

namespace Gamma\Pushpin\PushpinBundle\Interfaces\Factory;

use GripControl\WebSocketEvent;

interface EventFactoryInterface
{
    /**
     * @return string
     */
    public function getFormat();

    /**
     * @param WebSocketEvent $event
     * @param null           $format
     *
     * @return mixed
     */
    public function getEvent(WebSocketEvent $event, $format = null);
}
