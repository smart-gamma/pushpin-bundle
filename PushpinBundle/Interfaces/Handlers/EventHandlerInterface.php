<?php

namespace Gamma\Pushpin\PushpinBundle\Interfaces\Handlers;

use Gamma\Pushpin\PushpinBundle\Interfaces\Events\EventInterface;
use GripControl\WebSocketEvent;

interface EventHandlerInterface
{
    /**
     * @param EventInterface $event
     *
     * @return bool|WebSocketEvent
     */
    public function handle(EventInterface $event);

    /**
     * @return string
     */
    public function getEventType();

    /**
     * @param EventInterface $event
     *
     * @return bool
     */
    public function eventSupported(EventInterface $event);
}
