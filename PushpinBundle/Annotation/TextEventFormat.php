<?php

namespace Gamma\Pushpin\PushpinBundle\Annotation;

/**
 * @Annotation
 * @Target({"METHOD"})
 */
final class TextEventFormat
{
    /**
     * @var string
     * @Required
     */
    public $format;
}
