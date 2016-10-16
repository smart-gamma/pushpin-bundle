<?php

namespace Gamma\Pushpin\PushpinBundle\Interfaces\Handlers;

use Gamma\Pushpin\PushpinBundle\Events\Base\AbstractEvent;

interface EventHandlerInterface
{
    /**
     * @param AbstractEvent $event
     *
     * @return mixed
     */
    public function handle(AbstractEvent $event);

    /**
     * @return string
     */
    public function getEventType();

    /**
     * @param AbstractEvent $event
     *
     * @return mixed
     */
    public function eventSupported(AbstractEvent $event);
}
