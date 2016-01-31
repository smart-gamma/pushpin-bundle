<?php

namespace Gamma\Pushpin\PushpinBundle;

use Gamma\Pushpin\PushpinBundle\DependencyInjection\AddHandlersCompilePass;
use Gamma\Pushpin\PushpinBundle\DependencyInjection\EventsFactoryCompilePass;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class GammaPushpinBundle extends Bundle
{
    public function build(ContainerBuilder $container)
    {
        parent::build($container);

        $container->addCompilerPass(new AddHandlersCompilePass());
        $container->addCompilerPass(new EventsFactoryCompilePass());
    }
}
