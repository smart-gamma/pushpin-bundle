<?php

namespace LiveLife\WebSocketBundle\Messages;

use GripControl\WebSocketMessageFormat;

class GammaWebSocketMessage extends WebSocketMessageFormat
{
    /**
     * @return array
     */
    public function export()
    {
        $result['formats'] = [
            $this->name() => parent::export(),
        ];

        return $result;
    }
}
