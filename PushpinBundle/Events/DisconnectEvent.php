<?php

namespace Gamma\Pushpin\PushpinBundle\Events;

use Gamma\Pushpin\PushpinBundle\Events\Base\AbstractEvent;
use Gamma\Pushpin\PushpinBundle\Interfaces\Events\DisconnectEventInterface;
use Gamma\Pushpin\PushpinBundle\Interfaces\Events\OpenEventInterface;

class DisconnectEvent extends AbstractEvent implements DisconnectEventInterface
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
    public function hasSubTypes()
    {
        return false;
    }
}
