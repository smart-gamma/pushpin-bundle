<?php

namespace Gamma\Pushpin\PushpinBundle\Services;

use Gamma\Pushpin\PushpinBundle\Exceptions\Factory\WrongFactoryException;
use Gamma\Pushpin\PushpinBundle\Interfaces\Factory\EventFactoryInterface;
use GripControl\WebSocketEvent;
use Psr\Log\LoggerInterface;

class GripEventsFactory implements EventFactoryInterface
{
    /**
     * @var array
     */
    private $factories = [];

    /**
     * @var LoggerInterface
     */
    private $logger;

    /**
     * @param LoggerInterface $logger
     */
    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    /**
     * @param EventFactoryInterface $factory
     */
    public function addFactory(EventFactoryInterface $factory)
    {
        $this->factories[$factory->getFormat()] = $factory;
        $this->logger->info('added factory '.$factory->getFormat());
    }

    /**
     * {@inheritdoc}
     */
    public function getEvent(WebSocketEvent $webSocketEvent, $format = null)
    {
        $factory = $this->getFactory($webSocketEvent->type);

        $this->logger->info(
            __CLASS__.'Event data: '.json_encode(
                [
                    'format' => $format,
                    'event' => json_encode($webSocketEvent),
                    'factory' => $factory->getFormat(),
                ]
            )
        );

        return $factory->getEvent($webSocketEvent, $format);
    }

    /**
     * @param $type
     *
     * @return EventFactoryInterface
     */
    private function getFactory($type)
    {
        if (array_key_exists($type, $this->factories)) {
            return $this->factories[$type];
        }

        throw new WrongFactoryException($type);
    }

    /**
     * {@inheritdoc}
     */
    public function getFormat()
    {
    }
}
