<?php

namespace Gamma\Pushpin\PushpinBundle\Interfaces\Handlers;

use Gamma\Pushpin\PushpinBundle\Events\Base\AbstractJsonTextEvent;

interface JsonEventHandlerInterface
{
    /**
     * @param AbstractJsonTextEvent $event
     *
     * @return mixed
     */
    public function handle(AbstractJsonTextEvent $event);

    /**
     * @param AbstractJsonTextEvent $event
     *
     * @return bool
     */
    public function validateData(AbstractJsonTextEvent $event);
}
