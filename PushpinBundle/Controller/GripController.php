<?php

namespace Gamma\Pushpin\PushpinBundle\Controller;

use GripControl\GripControl;
use Gamma\Pushpin\PushpinBundle\DTO\WebSocketEventsDTO;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class GripController extends Controller
{
    /**
     * @param Request $request
     *
     * @return WebSocketEventsDTO
     *
     * @throws \Exception
     */
    protected function decodeWebSocketEvents(Request $request)
    {
        $events = GripControl::decode_websocket_events($request->getContent());

        if (count($events) > 0) {
            $dto = new WebSocketEventsDTO();
            $dto->webSocketEvents = $events;
            $dto->connectionId = $request->headers->get('connection-id');

            return $dto;
        }
    }

    /**
     * @param WebSocketEventsDTO $dto
     * @param int                $statusCode
     *
     * @return Response
     */
    protected function encodeWebSocketEvents(WebSocketEventsDTO $dto, $statusCode = 200)
    {
//      TODO: to DROP a WebSocket connection empty response should be sent.
//        if (!$dto->webSocketEvents) {
//            return new Response();
//        }

        $encodedEvents = GripControl::encode_websocket_events($dto->webSocketEvents);

        $response = new Response($encodedEvents, $statusCode);
        $response->headers->add([
            'content-type' => 'application/websocket-events',
            'Sec-WebSocket-Extensions' => 'grip; message-prefix=""',
        ]);

        return $response;
    }
}
