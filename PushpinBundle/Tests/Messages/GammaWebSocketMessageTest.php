<?php

namespace Gamma\Pushpin\PushpinBundle\Tests\Messages;

use Gamma\Pushpin\PushpinBundle\Messages\GammaWebSocketMessage;

class GammaWebSocketMessageTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @covers \Gamma\Pushpin\PushpinBundle\Messages\GammaWebSocketMessage::export
     */
    public function testGammaWebSocketMessageCreate()
    {
        $message = new GammaWebSocketMessage('test content');

        static::assertEquals(
            ['formats' => [
                    'ws-message' => [
                        'content' => 'test content',
                    ],
                ],
            ],
            $message->export()
        );
    }
}
