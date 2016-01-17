<?php

namespace Gamma\Pushpin\PushpinBundle\Interfaces;

interface WebSocketChannelInterface
{
    /**
     * @return string
     */
    public function getChannelName();
}