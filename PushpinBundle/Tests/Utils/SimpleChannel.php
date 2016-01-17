<?php
/**
 * Created for testing purposes only.
 */
namespace Gamma\Pushpin\PushpinBundle\Tests\Utils;

use Gamma\Pushpin\PushpinBundle\Interfaces\WebSocketChannelInterface;

class SimpleChannel implements WebSocketChannelInterface
{
    const CHANNEL_NAME = 'test-channel';

    /**
     * @return string
     */
    public function getChannelName()
    {
        return self::CHANNEL_NAME;
    }
}
