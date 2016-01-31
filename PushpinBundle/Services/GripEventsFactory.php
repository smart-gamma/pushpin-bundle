<?php

namespace Gamma\Pushpin\PushpinBundle\Services;

use Gamma\Pushpin\PushpinBundle\Interfaces\Events\TextEventInterface;
use Gamma\Pushpin\PushpinBundle\Interfaces\Factory\TextEventFactoryInterface;
use GripControl\WebSocketEvent;

class GripEventsFactory implements TextEventFactoryInterface
{
    /**
     * @var array
     */
    private $factories;

    public function addFactory(TextEventFactoryInterface $factory)
    {
        $this->factories[$factory->getFormat()] = $factory;
    }

    /**
     * @param string $format Text event format e.g. 'json'
     *
     * @return TextEventFactoryInterface
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
        $this->getFactoryByFormat($format)
            ->getEvent($event)
        ;
    }
}
