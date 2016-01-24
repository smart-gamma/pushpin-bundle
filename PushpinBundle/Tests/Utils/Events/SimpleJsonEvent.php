<?php

namespace Gamma\Pushpin\PushpinBundle\Tests\Utils\Events;

use Gamma\Pushpin\PushpinBundle\Events\Base\AbstractJsonEvent;
use JMS\Serializer\Annotation as JMS;

class SimpleJsonEvent extends AbstractJsonEvent
{
    /**
     * @JMS\Type("string")
     */
    public $string;

    /**
     * @JMS\Type("boolean")
     */
    public $bool;

    /**
     * @JMS\Type("integer")
     */
    public $int;

    /**
     * @JMS\Type("float")
     */
    public $float;

    /**
     * @JMS\Type("array")
     */
    public $array;
}
