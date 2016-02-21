<?php

namespace Gamma\Pushpin\PushpinBundle;

use Gamma\Pushpin\PushpinBundle\DependencyInjection\AddFactoriesPass;
use Gamma\Pushpin\PushpinBundle\DependencyInjection\AddHandlersPass;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class GammaPushpinBundle extends Bundle
{
    public function build(ContainerBuilder $container)
    {
        parent::build($container);

        $container->addCompilerPass(new AddHandlersPass());
        $container->addCompilerPass(new AddFactoriesPass());
    }
}
