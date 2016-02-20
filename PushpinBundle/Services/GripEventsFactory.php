<?php

namespace Gamma\Pushpin\PushpinBundle\Services;

use Gamma\Pushpin\PushpinBundle\Interfaces\Factory\EventFactoryInterface;
use GripControl\WebSocketEvent;

class GripEventsFactory implements EventFactoryInterface
{
    /**
     * @var array
     */
    private $factories = [];

    /**
     * @param EventFactoryInterface $factory
     */
    public function addFactory(EventFactoryInterface $factory)
    {
        $this->factories[$factory->getFormat()] = $factory;
    }

    /**
     * {@inheritdoc}
     */
    public function getEvent(WebSocketEvent $webSocketEvent, $format = null)
    {
        return $this->getFactory($format)->getEvent($webSocketEvent, $format);
    }

    /**
     * @param $format
     *
     * @return EventFactoryInterface
     */
    private function getFactory($format)
    {
        return $this->factories[$format];
    }

    /**
     * {@inheritdoc}
     */
    public function getFormat()
    {
    }
}
