<?php

namespace Gamma\Pushpin\PushpinBundle\Events\Base;

abstract class AbstractSubTypedEvent extends AbstractEvent
{
    /**
     * {@inheritdoc}
     */
    public function hasSubtypes()
    {
        return true;
    }

    /**
     * @return string
     */
    abstract public function getSubType();
}
