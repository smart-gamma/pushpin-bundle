<?php

namespace Gamma\Pushpin\PushpinBundle\Services\Events;

use Gamma\Pushpin\PushpinBundle\Events\Base\AbstractJsonEvent;
use Gamma\Pushpin\PushpinBundle\Interfaces\Events\TextEventInterface;
use Gamma\Pushpin\PushpinBundle\Interfaces\Factory\TextEventFactoryInterface;
use GripControl\WebSocketEvent;
use Psr\Log\LoggerAwareTrait;

class JsonEventFactory implements TextEventFactoryInterface
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
     * {@inheritdoc}
     */
    public function getFormat()
    {
        return 'json';
    }

    /**
     * {@inheritdoc}
     */
    public function getEvent(WebSocketEvent $event, $format = null)
    {
        return $this->resolveJsonEvent($event);
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


    /**
     * @param $eventName
     * @throws \RuntimeException
     */
    private function getClassByEventName($eventName)
    {
        if (isset($this->events[$eventName]['class'])) {
            return $this->events[$eventName]['class'];
        }

        throw new \RuntimeException(
            sprintf('Undefined WebSocket event "%s"', $eventName)
        );
    }

    /**
     * @param WebSocketEvent $webSocketEvent
     *
     * @return AbstractJsonEvent
     *
     * @throws \RuntimeException
     */
    private function resolveJsonEvent(WebSocketEvent $webSocketEvent)
    {
        if ($webSocketEvent->type !== TextEventInterface::EVENT_TYPE) {
            throw new \RuntimeException(
                sprintf(
                    'Cannot parse event with type "%s". Expected type is "%s"',
                    $webSocketEvent->type,
                    TextEventInterface::EVENT_TYPE
                )
            );
        }

        $eventName = $this->parser->getEventName($webSocketEvent);
        $className = sprintf('%s\%s', $this->baseNamespace,
            $this->getClassByEventName($eventName)
        );

        if (class_exists($className)) {
            $jsonEvent = new $className(
                $webSocketEvent->type,
                $webSocketEvent->content
            );

            return $this->serializer->deserialize($jsonEvent);
        }

        throw new \RuntimeException(sprintf('Class "%s" not exists', $className));
    }
}
