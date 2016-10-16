<?php


namespace Gamma\Pushpin\PushpinBundle\Exceptions\Factory;


class WrongFactoryException extends \RuntimeException
{
    /**
     * @param string $format
     */
    public function __construct($format)
    {
        $this->message = sprintf(
            'Cannot found Event Factory for type "%s"',
            $format
        );
    }
}