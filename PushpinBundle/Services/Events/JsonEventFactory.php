<?php

namespace Gamma\Pushpin\PushpinBundle\Services\Events;

use Gamma\Pushpin\PushpinBundle\Events\Base\AbstractJsonEvent;
use GripControl\WebSocketEvent;

class JsonEventFactory
{
    private $baseNamespace = '';

    private $events = [];

    /**
     * @var JsonEventParser
     */
    private $parser;

    /**
     * @var JsonEventSerializer
     */
    private $serializer;

    /**
     * @param $baseNamespace
     * @param array $events
     */
    public function configure($baseNamespace, array $events)
    {
        $this->baseNamespace = $baseNamespace;
        $this->events = $events;
    }

    /**
     * @param JsonEventParser     $parser
     * @param JsonEventSerializer $serializer
     */
    public function __construct(JsonEventParser $parser, JsonEventSerializer $serializer)
    {
        $this->parser = $parser;
        $this->serializer = $serializer;
    }

    /**
     * @param array $webSocketEvents
     *
     * @return array
     */
    public function getJsonEvents(array $webSocketEvents)
    {
        $resolved = [];
        foreach ($webSocketEvents as $webSocketEvent) {
            $resolved[] = $this->resolveJsonEvent($webSocketEvent);
        }

        return $resolved;
    }

    private function getEventClassByName($name)
    {
        return $this->events[$name];
    }

    /**
     * @param WebSocketEvent $webSocketEvent
     *
     * @return AbstractJsonEvent
     *
     * @throws \Exception
     */
    private function resolveJsonEvent(WebSocketEvent $webSocketEvent)
    {
        $eventName = $this->parser->getEventName($webSocketEvent);
        $className = sprintf('%s\%s', $this->baseNamespace,
                $this->getEventClassByName($eventName)
            );

        if (class_exists($className)) {
            $jsonEvent = new $className(
                $webSocketEvent->type,
                $webSocketEvent->content
            );

            return $this->serializer->deserialize($jsonEvent);
        }

        throw new \Exception(sprintf('Class "%s" not exists', $className));
    }
}
