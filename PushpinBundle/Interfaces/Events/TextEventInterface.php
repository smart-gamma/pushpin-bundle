<?php

namespace Gamma\Pushpin\PushpinBundle\Interfaces\Events;

interface TextEventInterface
{
    /**
     * @return string
     */
    public function getText();
}