<?php

namespace Gamma\Pushpin\PushpinBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

class EventsFactoryCompilePass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container)
    {
        if (!$container->has('gamma_pushpin.grip.events_factory')) {
            return;
        }

        $definition = $container->findDefinition(
            'gamma_pushpin.grip.events_factory'
        );

        $taggedServices = $container->findTaggedServiceIds(
            'gamma_pushpin.grip_event_factory'
        );
        foreach ($taggedServices as $id => $tags) {
            $definition->addMethodCall(
                'addFactory',
                [new Reference($id)]
            );
        }
    }
}
