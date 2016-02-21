<?php

namespace Gamma\Pushpin\PushpinBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

class AddHandlersPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container)
    {
        if (!$container->has('gamma.pushpin.grip.events_handler')) {
            return;
        }

        $definition = $container->findDefinition(
            'gamma.pushpin.grip.events_handler'
        );

        $taggedServices = $container->findTaggedServiceIds(
            'gamma.pushpin.grip_event_handler'
        );
        foreach ($taggedServices as $id => $tags) {
            foreach ($tags as $attributes) {
                $subtype = array_key_exists('type', $attributes) ?
                    $attributes['type'] :
                    false
                ;

                $definition->addMethodCall(
                    'addHandler',
                    [new Reference($id), $subtype]
                );
            }
        }
    }
}
