<?php

namespace Gamma\Pushpin\PushpinBundle\Services\Events;

use Doctrine\Common\Annotations\AnnotationRegistry;
use Gamma\Pushpin\PushpinBundle\Events\Base\AbstractJsonEvent;
use JMS\Serializer\Serializer;
use JMS\Serializer\SerializerBuilder;

class JsonEventSerializer
{
    const JSON_FORMAT = 'json';

    /**
     * @var Serializer
     */
    protected $serializer;

    public function __construct()
    {
        AnnotationRegistry::registerLoader('class_exists');
        $this->serializer = SerializerBuilder::create()->build();
    }

    /**
     * @param AbstractJsonEvent $event
     * 
     * @return AbstractJsonEvent
     */
    public function deserialize(AbstractJsonEvent $event)
    {
        $deSerialized = $this->serializer->deserialize(
            $event->getJson(),
            get_class($event),
            self::JSON_FORMAT
        );

        return $deSerialized;
    }
}
