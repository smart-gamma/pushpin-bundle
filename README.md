# GammaPushpinBundle
Symfony Bundle that helps you to add a realtime features to your applications using [Pushpin](http://pushpin.org/) reverse proxy. Integrates [php-gripcontrol](https://github.com/fanout/php-gripcontrol) library.

##Features
- Works with [WebSocket-over-HTTP Requests](https://github.com/fanout/pushpin/blob/master/docs/websocket-over-http.md) from Pushpin
- De serializes (using [jms/serializer](http://jmsyst.com/libs/serializer)) a TEXT events from Pushpin into DTOs (events) specified by your configuration
- Handling WebSocketEvent with your specific handler
- Pushpin helpers to publishing to a channel, subscribing, detaching etc.

Installation
------------
Install a bundle

    composer require "gamma/pushpin-bundle"

Register the bundle in `app/AppKernel.php`:

``` php
public function registerBundles()
{
    return array(
        // ...
        new Gamma\Pushpin\PushpinBundle\GammaPushpinBundle()
    );
}
```

Configuration
------------
```yaml
// config.yml
gamma_pushpin:
    proxy:
        control_uri: "http://localhost:5561/" # control URI to Pushpin
    web_socket:
        json_events:
            base_namespace: ~
```
For testing you need to [install a Pushpin](http://pushpin.org/docs/#install) on dev machine.
And enable WebSocket-over-HTTP in ```routes``` config file:

``` * localhost:80,over_http```

Usage
------------
Create an event class. Extend ```AbstractJsonEvent```. This class will hold a data from websocket clients:
```php
<?php
namespace AppBundle\WebsocketEvents\Chat;

use Gamma\Pushpin\PushpinBundle\Events\Base\AbstractJsonEvent;
use JMS\Serializer\Annotation\Type as JMS;

class ChatMessage extends AbstractJsonEvent
{

    /**
     * @var string
     * @JMS("string")
     */
    public $room;

    /**
     * @var string
     * @JMS("string")
     */
    public $comment;

}
```
Update configuration with your new event:
```yaml
// config.yml
gamma_pushpin:
    // ...
    web_socket:
        json_events:
            base_namespace: 'AppBundle\WebsocketEvents'
            mappings:
                chatMessage: # logical name of your event
                    class: 'Chat\ChatMessage' # base_namespace + clas should give fully qualified class name
```
Create handler service for your event by extending ```AbstractEventHandler``` class:
```php
<?php
namespace AppBundle\Services\WebSocket;

use Gamma\Pushpin\PushpinBundle\Events\Base\AbstractEvent;
use Gamma\Pushpin\PushpinBundle\Handlers\Base\AbstractEventHandler;
use Gamma\Pushpin\PushpinBundle\Interfaces\Events\TextEventInterface;
use GripControl\WebSocketEvent;

class ChatMessageHandler extends AbstractEventHandler
{
    const EVENT_TYPE = TextEventInterface::EVENT_TYPE;

    /**
     * {@inheritdoc}
     */
    public function handle(AbstractEvent $event)
    {
        //your logic


        //Example of creating response event to client:
        //$resultEvent = new WebSocketEvent('TEXT', 'Hello Client');
    }
}
````
Here you can return a single WebSocketEvent, array of WebSocketEvent objects or WebSocketEventsDTO that holds events as array as well.
Register handler as a Symfony service:
```YAML
//services.yml
services:
    app.chat_message_handler:
        class: AppBundle\Services\Websocket\ChatMessageHandler
        tags:
            - { name: gamma.pushpin.grip_event_handler, type: chatMessage }
```
Note: Here is ```type: <logicalEventName>``` should be similar to logical name of event in configuration.

In a Controller this Events should be passed to ```GripControl::encode_websocket_events``` function.
So last thing you need to do is to create a simple controller that Pushpin will access.
```php
<?php
namespace AppBundle\Controller;

use Gamma\Pushpin\PushpinBundle\Controller\GripController;
use Gamma\Pushpin\PushpinBundle\DTO\WebSocketEventsDTO;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

class ChatController extends GripController
{

    /**
     * @Route("/websocket/chat", name="app_websocket_chat_message")
     * @param Request $request
     * @param WebSocketEventsDTO $inputEvents
     *
     * @ParamConverter("inputEvents", converter="gamma.web_socket.events", options={"format": "json"})
     * @return Response
     */
    public function chatMessageAction(Request $request, WebSocketEventsDTO $inputEvents)
    {
        return $this->encodeWebSocketEvents(
            $this->get('gamma.pushpin.grip.events_handler')->handleEvents($inputEvents)
        );
    }
}
```
If everything is ok you should be able to connect to Pushpin's websocket port (7999 by default) with URL:
```ws://localhost:7999/websocket/chat```

You can test with [wscat](https://www.npmjs.com/package/wscat) utility:
```bash
$ wscat -c ws://localhost:7999/websocket/chat
connected (press CTRL+C to quit)
```
Now clients can send a message to your application:
```
chatMessage:{"room":"test","comment":"hello Symfony!"}
```

This will call your handler and return a result back to a client.

Working with channels
------------
Pushpin works as a publish-subscribe service. So you have ability to subscribe clients to a specific channels and publish a messages to it.
Anything that can ba a channel in your application should implement a ```WebSocketChannelInterface``` with one method ```getChannelName()```.
To publish messages you can also use ```\PubControl\PubControl::publish```

By calling methods on ```gamma.pushpin.pushpin_helper``` you can:
 - subscribe client to a channel ```subscribeToChannel($channel)```
 - publish to a channel ```sendWsMessageToChannel($channel, $message)```
 - unsubscribe from channel ```unSubscribeFromChannel($channel)```
 - detach connection ```detachConnection()```
additional info on Pushpin control messages

Example of working application
------------
[SimpleChatDemo](https://github.com/smart-gamma/simple-chat-demo)

TODO
------------
- HTTP streaming with Pushpin
- more documentation
- more ```phpunit```