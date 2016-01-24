<?php

namespace Gamma\Pushpin\PushpinBundle\Events\Base;

use Gamma\Pushpin\PushpinBundle\Interfaces\Events\TextEventInterface;

abstract class AbstractTextEvent extends AbstractEvent implements TextEventInterface
{
    /**
     * {@inheritdoc}
     */
    public function getType()
    {
        return self::EVENT_TYPE;
    }

    /**
     * {@inheritdoc}
     */
    public function getText()
    {
        return $this->content;
    }
}
