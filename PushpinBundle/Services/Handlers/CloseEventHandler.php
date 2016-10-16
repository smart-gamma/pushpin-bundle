<?php

namespace Gamma\Pushpin\PushpinBundle\Services\Handlers;

use Gamma\Pushpin\PushpinBundle\Events\Base\AbstractEvent;
use Gamma\Pushpin\PushpinBundle\Handlers\Base\AbstractEventHandler;
use Gamma\Pushpin\PushpinBundle\Interfaces\Events\CloseEventInterface;

class CloseEventHandler extends AbstractEventHandler
{
    const EVENT_TYPE = CloseEventInterface::EVENT_TYPE;

    /**
     * {@inheritdoc}
     */
    public function handle(AbstractEvent $event)
    {
        return $event;
    }

    /**
     * {@inheritdoc}
     */
    public function eventSupported(AbstractEvent $event)
    {
        return parent::eventSupported($event);
    }
}
