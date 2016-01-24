<?php

namespace Gamma\Pushpin\PushpinBundle\Interfaces\Events;

interface TextEventInterface extends EventInterface
{
    const EVENT_TYPE = 'TEXT';

    /**
     * @return string
     */
    public function getText();
}