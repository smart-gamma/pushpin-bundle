<?php

namespace Gamma\Pushpin\PushpinBundle\Services;

use Gamma\Pushpin\PushpinBundle\DTO\WebSocketEventsDTO;
use Gamma\Pushpin\PushpinBundle\Events\Base\AbstractEvent;
use Gamma\Pushpin\PushpinBundle\Events\Base\AbstractSubTypedEvent;
use Gamma\Pushpin\PushpinBundle\Handlers\Base\AbstractEventHandler;
use Psr\Log\LoggerInterface;

class GripEventsHandler
{
    /**
     * @var array
     */
    protected $handlers = [];

    /**
     * @var LoggerInterface
     */
    private $logger;

    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    /**
     * @param AbstractEventHandler $handler
     * @param string|null          $subType
     */
    public function addHandler(AbstractEventHandler $handler, $subType = null)
    {
        $this->logger->info(sprintf(
            '%s: handler:%s, subtype:%s',
            __FUNCTION__, get_class($handler), $subType
        ));

        if ($subType) {
            $this->handlers[$handler->getEventType()][$subType] = $handler;
        } else {
            $this->handlers[$handler->getEventType()] = $handler;
        }
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
     * @param WebSocketEventsDTO $events
     *
     * @return WebSocketEventsDTO
     */
    public function handleEvents(WebSocketEventsDTO $events)
    {
        $result = new WebSocketEventsDTO();

        array_walk($events->webSocketEvents, function(AbstractEvent $event) use ($result) {
            $handled = $this->handle($event);

            if (is_array($handled)) {
                $result->webSocketEvents = array_merge($result->webSocketEvents, $handled);
            }
            if ($handled instanceof  WebSocketEventsDTO) {
                $result->webSocketEvents = array_merge($result->webSocketEvents, $handled->webSocketEvents);
            }
            if ($handled instanceof AbstractEvent) {
                $result->webSocketEvents[] = $handled;
            }
        });

        return $result;
    }

    /**
     * @param AbstractEvent $event
     *
     * @return AbstractEventHandler
     */
    private function resolveHandler(AbstractEvent $event)
    {
        if ($event->hasSubTypes() && $event instanceof AbstractSubTypedEvent) {
            $this->logger->info(sprintf(
                '%s: event:%s, subtype:%s',
                __FUNCTION__, get_class($event), $event->getName()
            ));

            return $this->handlers[$event->getType()][$event->getSubType()];
        }

        return $this->handlers[$event->getType()];
    }
}
