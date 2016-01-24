<?php

namespace Gamma\Pushpin\PushpinBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

class AddHandlersCompilePass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container)
    {
        if (!$container->has('gamma_pushpin.grip.events_handler')) {
            return;
        }

        $definition = $container->findDefinition(
            'gamma_pushpin.grip.events_handler'
        );

        $taggedServices = $container->findTaggedServiceIds(
            'gamma_pushpin.grip_event_handler'
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
