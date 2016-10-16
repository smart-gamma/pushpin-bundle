<?php

namespace Gamma\Pushpin\PushpinBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * This is the class that validates and merges configuration from your app/config files.
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html#cookbook-bundles-extension-config-class}
 */
class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritdoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('gamma_pushpin');

        $rootNode
            ->children()
                ->arrayNode('proxy')
                    ->children()
                        ->scalarNode('control_uri')->end()
                    ->end()
                ->end()
                ->arrayNode('web_socket')
                    ->children()
                        ->arrayNode('json_events')
                            ->children()
                                ->scalarNode('base_namespace')->end()
                                ->arrayNode('mappings')
                                    ->prototype('array')
                                        ->children()
                                            ->scalarNode('class')->end()
                                            ->scalarNode('event')->end()
                                        ->end()
                                    ->end()
                                ->end()
                            ->end()
                        ->end()
                    ->end()
        ;

        return $treeBuilder;
    }
}
