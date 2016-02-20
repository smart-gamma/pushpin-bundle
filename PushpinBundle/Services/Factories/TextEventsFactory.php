<?php

namespace Gamma\Pushpin\PushpinBundle\Services\Factories;

use Gamma\Pushpin\PushpinBundle\Interfaces\Events\TextEventInterface;
use Gamma\Pushpin\PushpinBundle\Interfaces\Factory\EventFactoryInterface;
use GripControl\WebSocketEvent;

class TextEventsFactory implements EventFactoryInterface
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
    public function getEvent(WebSocketEvent $event, $format = null)
    {
        if (is_null($format)) {
            throw new \RuntimeException('Format cannot be null');
        }

        $this->getFactoryByFormat($format)
            ->getEvent($event)
        ;
    }
}
