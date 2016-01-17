<?php

namespace Gamma\Pushpin\PushpinBundle\Events\Base;

use Gamma\Pushpin\PushpinBundle\Exceptions\WrongJsonEventException;
use GripControl\WebSocketEvent;

abstract class AbstractJsonTextEvent extends AbstractTextEvent
{
    const DECODE_ASSOC = true;

    /**
     * @var array
     */
    protected $decodedJson;

    /**
     * {@inheritdoc}
     */
    public function __construct(WebSocketEvent $webSocketEvent)
    {
        parent::__construct($webSocketEvent);

        $this->decodedJson = json_decode($webSocketEvent->content, self::DECODE_ASSOC);

        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new WrongJsonEventException($webSocketEvent);
        }
    }

    /**
     * @return array|mixed
     */
    public function getDecodedJson()
    {
        return $this->decodedJson;
    }
}
