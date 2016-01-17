<?php

namespace Gamma\Pushpin\PushpinBundle\Interfaces\Events;

interface TextEventInterface extends EventInterface
{
    /**
     * @return string
     */
    public function getText();
}