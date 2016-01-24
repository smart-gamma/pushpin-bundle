<?php

namespace Gamma\Pushpin\PushpinBundle\Services;

use Gamma\Pushpin\PushpinBundle\Events\Base\AbstractEvent;
use Gamma\Pushpin\PushpinBundle\Events\Base\AbstractSubTypedEvent;
use Gamma\Pushpin\PushpinBundle\Handlers\Base\AbstractEventHandler;

class GripEventsHandler
{
    /**
     * @var array
     */
    protected $handlers;

    public function __construct()
    {
        $this->handlers = [];
    }

    /**
     * @param AbstractEventHandler $handler
     * @param string|null          $subType
     */
    public function addHandler(AbstractEventHandler $handler, $subType = null)
    {
        if ($subType) {
            $this->handlers[$handler->getEventType()][$subType] = $handler;

            return;
        }
        $this->handlers[$handler->getEventType()] = $handler;

        return;
    }

    /**
     * @param AbstractEvent $event
     *
     * @return AbstractEvent
     */
    public function handle(AbstractEvent $event)
    {
        $handler = $this->resolveHandler($event);

        return $handler->handle($event);
    }

    /**
     * @param AbstractEvent $event
     *
     * @return AbstractEventHandler
     */
    private function resolveHandler(AbstractEvent $event)
    {
        if ($event->hasSubTypes() && $event instanceof AbstractSubTypedEvent) {
            return $this->handlers[$event->getType()][$event->getSubType()];
        }

        return $this->handlers[$event->getType()];
    }
}
