<?php

namespace LiveLife\WebSocketBundle\Interfaces;

interface WebSocketChannelInterface
{
    /**
     * @return string
     */
    public function getChannelName();
}