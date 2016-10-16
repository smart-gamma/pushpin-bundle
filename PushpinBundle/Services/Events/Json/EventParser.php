<?php

namespace Gamma\Pushpin\PushpinBundle\Services\Events\Json;

use Gamma\Pushpin\PushpinBundle\Exceptions\WrongJsonEventException;
use GripControl\WebSocketEvent;

class EventParser
{
    /**
     * @var string
     */
    private static $separator = ':';

    /**
     * @param $separator
     */
    public static function setSeparator($separator)
    {
        self::$separator = $separator;
    }

    /**
     * @param WebSocketEvent $webSocketEvent
     *
     * @return string
     */
    public static function getEventName(WebSocketEvent $webSocketEvent)
    {
        $jsonStart = self::getJsonStartPos($webSocketEvent);

        return substr($webSocketEvent->content, 0, $jsonStart);
    }

    /**
     * @param WebSocketEvent $webSocketEvent
     *
     * @return string
     */
    public static function getEventJson(WebSocketEvent $webSocketEvent)
    {
        $jsonStart = self::getJsonStartPos($webSocketEvent);

        return substr($webSocketEvent->content, $jsonStart + strlen(self::$separator));
    }

    /**
     * @param WebSocketEvent $webSocketEvent
     *
     * @return int
     */
    private static function getJsonStartPos(WebSocketEvent $webSocketEvent)
    {
        $jsonStart = strpos($webSocketEvent->content, self::$separator.'{');

        if ($jsonStart === false) {
            throw new WrongJsonEventException($webSocketEvent);
        }

        return $jsonStart;
    }
}
