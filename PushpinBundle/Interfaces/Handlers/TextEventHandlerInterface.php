<?php

namespace Gamma\Pushpin\PushpinBundle\Interfaces\Handlers;

use Gamma\Pushpin\PushpinBundle\Interfaces\Events\TextEventInterface;

interface TextEventHandlerInterface
{
    /**
     * @param TextEventInterface $webSocketEvent
     *
     * @return bool
     */
    public function handle(TextEventInterface $webSocketEvent);

    /**
     * @param TextEventInterface $textEvent
     *
     * @return mixed
     */
    public function messageSupported(TextEventInterface $textEvent);

    /**
     * @return string
     */
    public function getMessageName();

    /**
     * @param TextEventInterface $textEvent
     * @return bool
     */
    public function validateParameters(TextEventInterface $textEvent);
}
