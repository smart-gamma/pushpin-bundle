<?php

namespace Gamma\Pushpin\PushpinBundle\Events\Base;

use Gamma\Pushpin\PushpinBundle\Services\Events\Json\EventParser;

abstract class AbstractJsonEvent extends AbstractTextEvent
{
    /**
     * @var string
     */
    private $json;

    /**
     * @var string
     */
    private $name;

    /**
     * {@inheritdoc}
     */
    public function __construct($type, $content)
    {
        parent::__construct($type, $content);

        $this->name = EventParser::getEventName($this);
        $this->json = EventParser::getEventJson($this);
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getJson()
    {
        return $this->json;
    }

    /**
     * {@inheritdoc}
     */
    public function getSubType()
    {
        return $this->name;
    }
}
