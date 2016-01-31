<?php


namespace Gamma\Pushpin\PushpinBundle\Request\ParamConverter;

use Gamma\Pushpin\PushpinBundle\Interfaces\Factory\TextEventFactoryInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Request\ParamConverter\ParamConverterInterface;
use Symfony\Component\HttpFoundation\Request;

class JsonEventsParamConverter implements ParamConverterInterface
{

    /**
     * @var TextEventFactoryInterface
     */
    private $factory;

    /**
     * @param TextEventFactoryInterface $eventFactory
     */
    public function __construct(TextEventFactoryInterface $eventFactory)
    {
        $this->factory = $eventFactory;
    }


    public function apply(Request $request, ParamConverter $configuration)
    {

    }

    public function supports(ParamConverter $configuration)
    {

    }
}