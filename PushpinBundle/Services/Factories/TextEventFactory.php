<?php

namespace Gamma\Pushpin\PushpinBundle\Services\Factories;

use Gamma\Pushpin\PushpinBundle\Exceptions\Factory\UnsupportedEventTypeException;
use Gamma\Pushpin\PushpinBundle\Interfaces\Events\TextEventInterface;
use Gamma\Pushpin\PushpinBundle\Interfaces\Factory\EventFactoryInterface;
use GripControl\WebSocketEvent;

class TextEventFactory implements EventFactoryInterface
{
    /**
     * @var array
     */
    private $factories;

    /**
     * @param EventFactoryInterface $factory
     */
    public function addFactory(EventFactoryInterface $factory)
    {
        $this->factories[$factory->getFormat()] = $factory;
    }

    /**
     * @param string $format Text event format e.g. 'json'
     *
     * @return EventFactoryInterface
     */
    private function getFactoryByFormat($format)
    {
        if (array_key_exists($format, $this->factories)) {
            return $this->factories[$format];
        }
        throw new \RuntimeException(
            sprintf('Unknown event format "%s"', $format)
        );
    }

    /**
     * {@inheritdoc}
     */
    public function getFormat()
    {
        return TextEventInterface::EVENT_TYPE;
    }

    /**
     * {@inheritdoc}
     */
    public function getEvent(WebSocketEvent $webSocketEvent, $format = null)
    {
        if (is_null($format)) {
            throw new \RuntimeException('Format cannot be null');
        }

        if ($webSocketEvent->type !== TextEventInterface::EVENT_TYPE) {
            throw new UnsupportedEventTypeException($this, $webSocketEvent);
        }

        $factory = $this->getFactoryByFormat($format);

        return $factory->getEvent($webSocketEvent);
    }
}
