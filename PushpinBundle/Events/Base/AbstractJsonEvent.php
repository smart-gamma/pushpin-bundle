<?php

namespace Gamma\Pushpin\PushpinBundle\Events\Base;

use Gamma\Pushpin\PushpinBundle\Services\Events\JsonEventParser;

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

        $this->name = JsonEventParser::getEventName($this);
        $this->json = JsonEventParser::getEventJson($this);
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
}
